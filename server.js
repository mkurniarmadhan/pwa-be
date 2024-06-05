const express = require("express");
const bodyParser = require("body-parser");
const admin = require("firebase-admin");
const app = express();
const cors = require("cors");
app.use(bodyParser.json());
app.use(cors());

// Inisialisasi Firebase Admin SDK
const serviceAccount = require("./serviceAccountKey.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://blogapp-5177e.firebaseio.com",
});

// Simpan token di array untuk demo (Anda harus menyimpan di database dalam produksi)
let tokens = [];

app.post("/subscribe", (req, res) => {
  const { token } = req.body;
  if (!tokens.includes(token)) {
    tokens.push(token);
  }
  res.status(201).json({});
});

app.post("/send-notification", (req, res) => {
  const message = {
    notification: {
      title: "Barang Baru Tersedia!",
      body: "Cek barang baru di aplikasi kami.",
    },
    tokens: tokens, // Array of FCM tokens
  };

  admin
    .messaging()
    .sendMulticast(message)
    .then((response) => {
      console.log(response.successCount + " messages were sent successfully");
      res.status(200).json({ success: response.successCount });
    })
    .catch((error) => {
      console.error("Error sending message:", error);
      res.status(500).json({ error });
    });
});

app.listen(3000, () => {
  console.log("Server started on port 3000");
});
