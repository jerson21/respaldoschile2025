require('dotenv').config();
const express = require('express');
const mysql = require('mysql2/promise');

const app = express();
const port = process.env.PORT || 3000;

const pool = mysql.createPool({
  host: process.env.DB_HOST || 'localhost',
  port: process.env.DB_PORT ? Number(process.env.DB_PORT) : 3306,
  user: process.env.DB_USER || 'user',
  password: process.env.DB_PASSWORD || 'secret',
  database: process.env.DB_NAME || 'respaldos',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

app.get('/', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT 1 + 1 AS result');
    res.json({ message: 'Hello World', dbTest: rows[0].result });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Database connection error' });
  }
});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});