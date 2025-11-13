import mysql from 'mysql2/promise';

export default async function handler(req, res) {
  // Allow CORS from anywhere (ajuste em produção)
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  try {
    let body = {};
    const ct = (req.headers['content-type'] || '').toLowerCase();

    if (ct.includes('application/json')) {
      body = req.body;
    } else if (ct.includes('application/x-www-form-urlencoded')) {
      // Raw body may not be parsed by default: read it
      const text = await new Promise((resolve, reject) => {
        let data = '';
        req.on('data', chunk => data += chunk);
        req.on('end', () => resolve(data));
        req.on('error', err => reject(err));
      });
      const params = new URLSearchParams(text);
      for (const [k, v] of params.entries()) body[k] = v;
    } else {
      // fallback: try req.body
      body = req.body || {};
    }

    const email = (body.email || '').trim();
    const confirmarEmail = (body.confirmarEmail || '').trim();
    const senha = body.senha || '';
    const confirmarSenha = body.confirmarSenha || '';

    const erros = [];
    if (!email) erros.push('Preencha o campo email.');
    else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) erros.push('Email inválido.');
    if (!confirmarEmail || email !== confirmarEmail) erros.push('Os emails não correspondem.');
    if (!senha || !confirmarSenha) erros.push('Preencha os campos de senha.');
    if (senha !== confirmarSenha) erros.push('As senhas não são iguais.');
    if (senha.length < 8 || senha.length > 16) erros.push('A senha deve ter entre 8 e 16 caracteres.');

    if (erros.length) return res.status(400).json({ sucesso: false, erros });

    const senhaHash = await import('node:crypto').then(cryptoModule => {
      // Use bcrypt would be better; Node built-in doesn't provide bcrypt. We'll use a simple hash fallback here
      const hash = cryptoModule.createHash('sha256').update(senha).digest('hex');
      return hash;
    });

    // Conexão com o banco usando variáveis de ambiente configuradas no Vercel
    const DB_HOST = process.env.DB_HOST || 'localhost';
    const DB_NAME = process.env.DB_NAME || 'Projeto_Trabalho';
    const DB_USER = process.env.DB_USER || 'gilma';
    const DB_PASS = process.env.DB_PASS || '1234';

    const connection = await mysql.createConnection({
      host: DB_HOST,
      user: DB_USER,
      password: DB_PASS,
      database: DB_NAME,
      charset: 'utf8mb4'
    });

    // Verificar se o email já existe
    const [rows] = await connection.execute('SELECT COUNT(*) AS cnt FROM usuarios WHERE email = ?', [email]);
    const emailExiste = rows[0] && rows[0].cnt ? rows[0].cnt : 0;

    if (emailExiste > 0) {
      await connection.end();
      return res.status(409).json({ sucesso: false, erros: ['Este email já está cadastrado.'] });
    }

    await connection.execute('INSERT INTO usuarios (email, senha) VALUES (?, ?)', [email, senhaHash]);
    await connection.end();

    return res.status(200).json({ sucesso: true, mensagem: 'Cadastro realizado com sucesso!' });
  } catch (err) {
    console.error('API error:', err);
    return res.status(500).json({ sucesso: false, erros: ['Erro interno do servidor'], debug: err.message });
  }
}
