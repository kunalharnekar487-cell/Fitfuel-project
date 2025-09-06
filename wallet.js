// wallet.js

let walletBalance = parseFloat(localStorage.getItem("fitfuel_wallet")) || 0;
let walletHistory = JSON.parse(localStorage.getItem("fitfuel_wallet_history")) || [];

const walletBalanceEl = document.getElementById("wallet-balance");
const transactionListEl = document.getElementById("transaction-list");

function updateWalletDisplay() {
  walletBalanceEl.textContent = walletBalance.toFixed(2);

  transactionListEl.innerHTML = "";
  walletHistory.slice().reverse().forEach(entry => {
    const li = document.createElement("li");
    li.innerHTML = `
      <div class="p-3 border rounded ${entry.type === 'Credited' ? 'bg-green-50' : 'bg-red-50'}">
        <strong>${entry.type}</strong>: ₹${entry.amount} <br>
        <span class="text-xs text-gray-500">${entry.date}</span>
      </div>
    `;
    transactionListEl.appendChild(li);
  });
}

function addMoney() {
  const amount = parseFloat(prompt("Enter amount to add:"));
  if (!isNaN(amount) && amount > 0) {
    walletBalance += amount;
    saveTransaction("Credited", amount);
    updateWalletDisplay();
    alert(`₹${amount.toFixed(2)} added successfully!`);
  } else {
    alert("Please enter a valid amount.");
  }
}

function saveTransaction(type, amount) {
  const transaction = {
    type,
    amount: amount.toFixed(2),
    date: new Date().toLocaleString(),
  };
  walletHistory.push(transaction);
  localStorage.setItem("fitfuel_wallet", walletBalance.toFixed(2));
  localStorage.setItem("fitfuel_wallet_history", JSON.stringify(walletHistory));
}

updateWalletDisplay();
