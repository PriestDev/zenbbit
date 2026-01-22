<?php $pageTitle = 'Withdraw'; $includeIziToast = true; include 'includes/head.php'; ?>
<body class="light-mode dashboard-body">

  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>

<style>
  .toast {
  visibility: hidden;
  min-width: 200px;
  background: #00c985;
  color: #fff;
  text-align: center;
  border-radius: 8px;
  padding: 12px;
  position: fixed;
  left: 50%;
  top: 40px;
  transform: translateX(-50%);
  z-index: 1000;
  font-size: 14px;
  opacity: 0;
  transition: opacity 0.4s, bottom 0.4s;
}

.toast.show {
  visibility: visible;
  opacity: 1;
  top: 60px;
}

.mark-btn {
  width: 100%;
  background: #007bff;
  color: #fff;
  border: none;
  padding: 7px;
  cursor: pointer;
  border-radius: 4px;
  margin-top: 8px;
}
.mark-btn:hover { background: #0056b3; }

/* ================= SIDEBAR STYLES ======================= */
.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  width: 250px;
  height: 100vh;
  background: #1e1e1e;
  padding-top: 60px;
  transform: translateX(-100%);
  transition: transform 0.3s ease;
  z-index: 998;
  overflow-y: auto;
}

.sidebar.open {
  transform: translateX(0);
}

.sidebar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #333;
}

.sidebar-header h3 {
  margin: 0;
  font-size: 18px;
  color: #fff;
}

.close-sidebar-btn {
  background: none;
  border: none;
  color: #fff;
  font-size: 24px;
  cursor: pointer;
  padding: 0;
}

.sidebar-nav {
  padding: 10px 0;
}

.sidebar-item {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px 20px;
  color: #fff;
  text-decoration: none;
  transition: background 0.2s ease;
  border-left: 3px solid transparent;
}

.sidebar-item:hover {
  background: rgba(255, 255, 255, 0.1);
  border-left-color: #622faa;
}

.sidebar-item i {
  font-size: 18px;
}

.sidebar-item span {
  font-size: 14px;
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  z-index: 997;
}

.sidebar-overlay.show {
  display: block;
}

.toggle-sidebar-btn {
  background: none;
  border: none;
  color: #622faa;
  font-size: 24px;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
}

.toggle-sidebar-btn:hover {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
}

/* Light mode sidebar */
body.light-mode .sidebar {
  background: #f8f9fa;
}

body.light-mode .sidebar-header {
  border-bottom: 1px solid #ddd;
}

body.light-mode .close-sidebar-btn,
body.light-mode .sidebar-header h3 {
  color: #333;
}

body.light-mode .sidebar-item {
  color: #333;
}

body.light-mode .sidebar-item:hover {
  background: #e8e8e8;
}

/* ================= LIGHT MODE ======================= */
body.light-mode .header {
  background: #fff;
  border-bottom: 0.5px solid #ddd;
}
body.light-mode .icon-btn {
  background: #f4f4f4;
  color: #ff8c00;
}
body.light-mode .icon-btn:hover {
  background: #eaeaea;
}
body.light-mode .badge {
  background: #0d6efd;
  color: #fff;
}

body.light-mode .dropdown {
  background: #fff;
  border: 1px solid #ddd;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
body.light-mode .dropdown h4 {
  background: #f7f7f7;
  color: #111;
  border-bottom: 1px solid #ddd;
}
body.light-mode .dropdown .notif {
  color: #333;
  border-bottom: 1px solid #eee;
}
body.light-mode .dropdown .notif:hover {
  background: #f2f2f2;
}

body.light-mode .mark-btn {
  background: #007bff;
  color: #fff;
}
body.light-mode .mark-btn:hover {
  background: #0056b3;
}
</style>

<script>
(() => {
  const POLL_INTERVAL = 5000;
  const fetchUrl = 'fetch_notifications.php';
  const markUrl  = 'mark_notifications.php';

  const notifBtn = document.getElementById('notifBtn');
  const notifBadge = document.getElementById('notifBadge');
  const notifDropdown = document.getElementById('notifDropdown');
  const notifList = document.getElementById('notifList');
  const markReadBtn = document.getElementById('markReadBtn');

  notifBtn.addEventListener('click', () => {
    const isOpen = notifDropdown.style.display === 'block';
    notifDropdown.style.display = isOpen ? 'none' : 'block';
    notifBtn.setAttribute('aria-expanded', String(!isOpen));
  });

  document.addEventListener('click', (e) => {
    if (!document.querySelector('.notification-wrapper').contains(e.target)) {
      notifDropdown.style.display = 'none';
      notifBtn.setAttribute('aria-expanded', 'false');
    }
  });

  async function fetchNotifications() {
    try {
      const res = await fetch(fetchUrl, { credentials: 'same-origin' });
      if (!res.ok) return;
      const data = await res.json();
      notifBadge.textContent = data.count || 0;

      notifList.innerHTML = '';
      if (data.notifications && data.notifications.length) {
        data.notifications.forEach(n => {
          const div = document.createElement('div');
          div.className = 'notif';
          const time = n.time ? new Date(n.time).toLocaleString() : '';
          div.textContent = `${n.message} · ${time}`;
          notifList.appendChild(div);
        });
      } else {
        notifList.innerHTML = '<div class="notif">No new notifications</div>';
      }
    } catch (err) {
      console.error('fetchNotifications error:', err);
    }
  }

  async function markAllRead() {
    try {
      const res = await fetch(markUrl, {
        method: 'POST',
        credentials: 'same-origin'
      });
      if (!res.ok) throw new Error('Network error');
      const data = await res.json();
      if (data.status === 'ok') {
        notifBadge.textContent = '0';
        notifList.innerHTML = '<div class="notif">No new notifications</div>';
      }
    } catch (err) {
      console.error('markAllRead error:', err);
    }
  }

  markReadBtn.addEventListener('click', (e) => {
    e.preventDefault();
    markAllRead();
  });

  fetchNotifications();
  setInterval(fetchNotifications, POLL_INTERVAL);
})();
</script>

<script>
// Sidebar toggle functionality
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

toggleSidebarBtn.addEventListener('click', () => {
  sidebar.classList.add('open');
  sidebarOverlay.classList.add('show');
});

closeSidebarBtn.addEventListener('click', () => {
  sidebar.classList.remove('open');
  sidebarOverlay.classList.remove('show');
});

sidebarOverlay.addEventListener('click', () => {
  sidebar.classList.remove('open');
  sidebarOverlay.classList.remove('show');
});

document.querySelectorAll('.sidebar-item').forEach(item => {
  item.addEventListener('click', () => {
    sidebar.classList.remove('open');
    sidebarOverlay.classList.remove('show');
  });
});
</script>

<script>
const body = document.body;
const btn = document.getElementById("themeToggleBtn");

const savedTheme = localStorage.getItem("theme") || "light";
if (savedTheme === "light") {
  body.classList.add("light-mode");
  updateIcon();
}

btn.addEventListener("click", () => {
  body.classList.toggle("light-mode");
  if (body.classList.contains("light-mode")) {
    localStorage.setItem("theme", "light");
  } else {
    localStorage.setItem("theme", "dark");
  }
  updateIcon();
});

function updateIcon() {
  const icon = btn.querySelector("i");
  if (body.classList.contains("light-mode")) {
    icon.className = "fas fa-sun icon-purple";
  } else {
    icon.className = "fas fa-moon icon-purple";
  }
}
</script>

<style>
  body { background:#121212; font-family: Arial, sans-serif; color:#fff; }
  .card { background:#1e1e1e; padding:20px; border-radius:10px; margin:20px; }
  .balance { font-size:24px; margin:10px 0; }
  .wallet-info { display:block; justify-content:center; font-size:14px; margin-bottom:15px; text-align:right; }
  .wallet-inf { display:flex; justify-content:space-between; align-items:center; font-size:14px; margin-bottom:15px; }
  .in-out { display:flex; justify-content:space-between; margin:15px 0; }
  .actions { display:flex; justify-content:space-around; }
  .actions div { text-align:center; cursor:pointer; }
  .actions div i { font-size:24px; margin-bottom:5px; }
  .form-group { margin-bottom:15px; }
  .form-group label { display:block; margin-bottom:5px; font-weight:600; }
  .form-group input, .form-group select { width:100%; padding:10px; border:1px solid #333; border-radius:6px; background:#0d1117; color:#fff; }
  .form-group input:focus, .form-group select:focus { outline:none; border-color:#622faa; }
  .btn-primary { width:100%; padding:12px; background:#622faa; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:16px; font-weight:600; transition:0.3s; }
  .btn-primary:hover { background:#8c3fca; }
  .list { display:block; margin:2rem 2.3rem; }
  @media(max-width:415px){ .homresp{ display:none; } }
</style>

<main style="padding-bottom: 6rem;">
  <section class="hom mb-5" style="margin-top: 6rem; margin-bottom: 8rem; width: 100%; max-width: 700px; margin-left: auto; margin-right: auto; padding: 0 20px;">
    <div class="card" style="padding: 40px 30px;">
      <div class="wallet-inf" style="margin-bottom: 2.5rem;">
        <div>
          <h2 class="settings-title">Withdraw Funds</h2>
          <p class="settings-subtitle">Request a withdrawal from your account</p>
        </div>
      </div>
    
    <form id="withdrawForm">
      <div class="form-group">
        <label for="withdrawMethod">Select Withdrawal Method</label>
        <select id="withdrawMethod" required>
          <option value="">-- Choose Method --</option>
          <option value="bank">Bank Transfer</option>
          <option value="card">Credit/Debit Card</option>
          <option value="crypto">Cryptocurrency</option>
          <option value="wallet">E-Wallet</option>
        </select>
      </div>

      <div class="form-group">
        <label for="withdrawAmount">Amount</label>
        <input type="number" id="withdrawAmount" placeholder="Enter amount" step="0.01" required>
      </div>

      <div class="form-group">
        <label for="withdrawCurrency">Currency</label>
        <select id="withdrawCurrency" required>
          <option value="USD">USD</option>
          <option value="EUR">EUR</option>
          <option value="GBP">GBP</option>
          <option value="BTC">BTC</option>
          <option value="ETH">ETH</option>
        </select>
      </div>

      <div class="form-group">
        <label for="withdrawAddress">Recipient Address/Account</label>
        <input type="text" id="withdrawAddress" placeholder="Enter bank account or wallet address" required>
      </div>

      <button type="submit" class="btn-primary">Request Withdrawal</button>
    </form>
    </div>
  </section>
</main>

<section class="footer">
    <a href="index.html" style="text-decoration: none; color: #622faa;">
        <div class="swap">
            <div><i class="bi bi-house-door"></i> </div>
            <div><span>Home</span></div>
        </div>
    </a>

    <a href="profile.php" style="text-decoration: none; color: #622faa;" id="profile">
        <div class="swap" >
            <div><i class="bi bi-gear" style="font-size: 1.2rem;cursor: pointer;"></i></div>
            <div><span>Profile</span></div>
        </div>
    </a>

    <a href="connect.php" style="text-decoration: none; color: #622faa;" class="conne">
        <div class="swap" >
            <div><i class="fas fa-link" style="font-size: 1.2rem;cursor: pointer;"></i></div>
            <div><span>Connect</span></div>
        </div>
    </a>

    <a href="buy.php" style="text-decoration: none; color: #622faa;" class="by">
        <div class="swap">
            <div><i class="bi bi-credit-card"></i> </div>
            <div><span>Buy</span></div>
        </div>
    </a>
</section>

<style>
    .swap{
        display: block;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        text-align: center;
    }
     .swap i{
        font-size: 1rem;
     }
      .swap a{
        text-decoration: none;
      }
      .swap span{
        text-decoration: none;
      }
    
    .footer{
        display:flex;
        justify-content: space-around;
        align-items: center;
        bottom: 0;
        left: 0;
        right: 0;
        position: fixed;
        background: black;
        padding: 1rem;
    }
</style>

<script>
document.getElementById('withdrawForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const method = document.getElementById('withdrawMethod').value;
  const amount = document.getElementById('withdrawAmount').value;
  const currency = document.getElementById('withdrawCurrency').value;
  const address = document.getElementById('withdrawAddress').value;
  
  if(method && amount && currency && address) {
    iziToast.success({
      title: 'Success',
      message: `Withdrawal request initiated: ${amount} ${currency} via ${method}`,
      position: 'topRight'
    });
  }
});
</script>

  <!-- External Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Dashboard Scripts -->
  <script src="js/script.js"></script>

</body>
</html>
