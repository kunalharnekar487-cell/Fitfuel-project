const express = require("express");
const cors = require("cors");
const bodyParser = require("body-parser");
const otpGenerator = require("otp-generator");

const app = express();
app.use(cors());
app.use(bodyParser.json());

// Temporary in-memory store for OTPs
let otpStore = {};

// Send OTP
app.post("/send-otp", (req, res) => {
  const { phone } = req.body;

  if (!phone) {
    return res.status(400).json({ message: "Phone number is required" });
  }

  const otp = otpGenerator.generate(6, { upperCaseAlphabets: false, specialChars: false });
  otpStore[phone] = otp;

  console.log(`OTP for ${phone}: ${otp}`); // In real app, send via SMS API like Twilio

  res.json({ message: "OTP sent successfully!" });
});

// Verify OTP
app.post("/verify-otp", (req, res) => {
  const { phone, otp } = req.body;

  if (otpStore[phone] && otpStore[phone] === otp) {
    delete otpStore[phone]; // remove after verification
    return res.json({ success: true, message: "OTP verified successfully!", role: "user" });
  }

  res.json({ success: false, message: "Invalid OTP" });
});

app.listen(5000, () => console.log("Server running on http://localhost:5000"));
