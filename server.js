const express = require("express");
const { createProxyMiddleware } = require("http-proxy-middleware");
const path = require("path");
const app = express();
const PORT = 3000;

// Définir le répertoire des fichiers statiques
app.use(express.static(path.join(__dirname, "public")));

// Proxy pour les fichiers PHP
app.use(
  "/php",
  createProxyMiddleware({
    target: "http://localhost:8000", // Adresse de votre serveur PHP local
    changeOrigin: true,
    pathRewrite: {
      "^/php": "", // Supprime le préfixe /php lors de la redirection
    },
  })
);

// Routes pour les pages
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "index.html"));
});

app.get("/catalogue", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "catalogue.html"));
});

app.get("/detail", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "detail.html"));
});

app.listen(PORT, () => {
  console.log(`Serveur en cours d'exécution sur http://localhost:${PORT}`);
});
