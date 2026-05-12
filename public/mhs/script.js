/* ========================================
   OASIS - One Access Student Information System
   LP3I Banten - JavaScript
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations on scroll
    initScrollAnimations();
    
    // Animate stats on load
    animateOnLoad();
    
    // Close dropdowns on outside click
    document.addEventListener('click', handleOutsideClick);
});

// ===== PROFILE DROPDOWN =====
function toggleProfileMenu() {
    const dropdowns = [
        document.getElementById('profileDropdownMobile'),
        document.getElementById('profileDropdownDesktop')
    ];

    // cari yang lagi tampil (tidak display:none)
    const activeDropdown = dropdowns.find(d => 
        d && d.offsetParent !== null
    );

    const arrow = document.getElementById('profileArrow');

    if (activeDropdown) {
        activeDropdown.classList.toggle('show');
    }

    if (arrow) arrow.classList.toggle('rotate');
    
    // Close notification panel if open
    closeNotifPanel();
}

// ===== NOTIFICATION PANEL =====
function toggleNotifPanel() {
    const panel = document.getElementById('notifPanel');
    const overlay = document.getElementById('overlay');
    
    panel.classList.toggle('show');
    overlay.classList.toggle('show');
    
    // Close profile dropdown if open
    closeProfileDropdown();
}

function toggleMobileNotif() {
    toggleNotifPanel();
}

function toggleMobileProfile() {
    toggleProfileMenu();
}

function closeNotifPanel() {
    const panel = document.getElementById('notifPanel');
    const overlay = document.getElementById('overlay');
    panel.classList.remove('show');
    overlay.classList.remove('show');
}

function closeProfileDropdown() {
    const dropdowns = [
        document.getElementById('profileDropdownMobile'),
        document.getElementById('profileDropdownDesktop')
    ];

    dropdowns.forEach(d => {
        if (d) d.classList.remove('show');
    });

    const arrow = document.getElementById('profileArrow');
    if (arrow) arrow.classList.remove('rotate');
}

function closeAllPanels() {
    closeNotifPanel();
    closeProfileDropdown();
}

// ===== OUTSIDE CLICK HANDLER =====
function handleOutsideClick(e) {
    const profileDropdown = document.getElementById('profileDropdown');
    const navProfile = document.querySelector('.nav-profile');
    
    if (profileDropdown && profileDropdown.classList.contains('show')) {
        if (navProfile && !navProfile.contains(e.target)) {
            closeProfileDropdown();
        }
    }
}

// ===== SEMESTER FILTER =====
function filterSemester() {
    const filter = document.getElementById('semesterFilter').value;
    const rows = document.querySelectorAll('#transcriptTable tbody tr');
    
    rows.forEach(function(row) {
        const semester = row.getAttribute('data-semester');
        
        if (filter === 'all') {
            row.style.display = '';
            row.style.animation = 'slideInUp 0.3s ease forwards';
        } else if (semester === filter) {
            row.style.display = '';
            row.style.animation = 'slideInUp 0.3s ease forwards';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update summary based on filter
    updateTranscriptSummary(filter);
}

function updateTranscriptSummary(semester) {
    const rows = document.querySelectorAll('#transcriptTable tbody tr');
    let totalSKS = 0;
    let totalBobot = 0;
    
    rows.forEach(function(row) {
        if (row.style.display !== 'none') {
            const sks = parseInt(row.cells[2].textContent);
            const bobot = parseFloat(row.cells[4].textContent);
            totalSKS += sks;
            totalBobot += bobot;
        }
    });
    
    const ipk = totalSKS > 0 ? (totalBobot / totalSKS).toFixed(2) : '0.00';
    
    const summaryItems = document.querySelectorAll('.summary-item');
    if (summaryItems.length >= 3) {
        summaryItems[0].querySelector('strong').textContent = totalSKS;
        summaryItems[1].querySelector('strong').textContent = totalBobot.toFixed(1);
        summaryItems[2].querySelector('strong').textContent = ipk;
    }
}

// ===== PRINT TRANSCRIPT =====
function printTranscript() {
    window.print();
}

// ===== SCROLL ANIMATIONS =====
function initScrollAnimations() {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observe elements
    const animateElements = document.querySelectorAll('.stat-card, .payment-main-card, .payment-history-card, .transcript-card, .internship-card, .notification-card');
    
    animateElements.forEach(function(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });
}

// ===== ANIMATE ON LOAD =====
function animateOnLoad() {
    // Animate progress bars
    setTimeout(function() {
        const progressBars = document.querySelectorAll('.payment-progress-fill, .internship-progress-fill, .progress-bar-custom');
        progressBars.forEach(function(bar) {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(function() {
                bar.style.width = width;
            }, 100);
        });
    }, 300);
    
    // Animate stat values
    const statValues = document.querySelectorAll('.stat-value');
    statValues.forEach(function(el) {
        const finalText = el.textContent;
        const finalNum = parseFloat(finalText.replace(/[^0-9.]/g, ''));
        
        if (!isNaN(finalNum) && finalNum < 100) {
            let current = 0;
            const step = finalNum / 30;
            const prefix = finalText.match(/^[^0-9]*/)[0];
            const suffix = finalText.match(/[^0-9]*$/)[0];
            
            const counter = setInterval(function() {
                current += step;
                if (current >= finalNum) {
                    el.textContent = finalText;
                    clearInterval(counter);
                } else {
                    el.textContent = prefix + current.toFixed(2) + suffix;
                }
            }, 30);
        }
    });
}

// ===== NAVBAR SCROLL EFFECT =====
let lastScrollY = 0;

window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    const currentScrollY = window.scrollY;
    
    if (currentScrollY > 50) {
        navbar.style.boxShadow = '0 4px 30px rgba(30, 58, 95, 0.4)';
        navbar.style.height = '58px';
    } else {
        navbar.style.boxShadow = '0 2px 20px rgba(30, 58, 95, 0.3)';
        navbar.style.height = '64px';
    }
    
    lastScrollY = currentScrollY;
});

// ===== SMOOTH SCROLL =====
document.querySelectorAll('a[href^="#"]:not([data-toggle="tab"])')
    .forEach(function(anchor) {

    anchor.addEventListener('click', function(e) {

        e.preventDefault();

        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const target = document.querySelector(targetId);
        if (target) {
            const offsetTop = target.offsetTop - 80;

            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });

});


// ===== MARK NOTIFICATION AS READ (on click) =====
document.querySelectorAll('.notif-item').forEach(function(item) {
    item.addEventListener('click', function() {
        this.classList.remove('unread');
        updateNotifBadge();
    });
});

function updateNotifBadge() {
    const unreadCount = document.querySelectorAll('.notif-item.unread').length;
    const badges = document.querySelectorAll('.notif-badge');
    badges.forEach(function(badge) {
        if (unreadCount > 0) {
            badge.textContent = unreadCount;
            badge.style.display = '';
        } else {
            badge.style.display = 'none';
        }
    });
}

// ===== KEYBOARD SHORTCUTS =====
document.addEventListener('keydown', function(e) {
    // Escape to close panels
    if (e.key === 'Escape') {
        closeAllPanels();
    }
    
    // Ctrl+P for print
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        printTranscript();
    }
});

// ===== PAY NOW BUTTON TOAST =====
document.querySelectorAll('.btn-pay-now').forEach(function(btn) {
    btn.addEventListener('click', function() {
        showToast('Mengarahkan ke halaman pembayaran...', 'info');
    });
});

document.querySelectorAll('.btn-pay-detail').forEach(function(btn) {
    btn.addEventListener('click', function() {
        showToast('Menampilkan detail pembayaran', 'info');
    });
});

// ===== TOAST NOTIFICATION =====
function showToast(message, type) {
    // Remove existing toast
    const existing = document.querySelector('.oasis-toast');
    if (existing) existing.remove();
    
    const toast = document.createElement('div');
    toast.className = 'oasis-toast';
    toast.style.cssText = `
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: ${type === 'info' ? '#1e3a5f' : type === 'success' ? '#38a169' : '#e53e3e'};
        color: #fff;
        padding: 14px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: toastIn 0.4s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 380px;
    `;
    
    const icon = type === 'info' ? 'fa-info-circle' : type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
    
    // Add animation styles
    if (!document.getElementById('toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            @keyframes toastIn {
                from { opacity: 0; transform: translateY(20px) scale(0.95); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }
            @keyframes toastOut {
                from { opacity: 1; transform: translateY(0) scale(1); }
                to { opacity: 0; transform: translateY(20px) scale(0.95); }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(toast);
    
    setTimeout(function() {
        toast.style.animation = 'toastOut 0.3s ease forwards';
        setTimeout(function() {
            toast.remove();
        }, 300);
    }, 3000);
}

// ===== LOGOUT BUTTON =====
document.querySelectorAll('.logout-item').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            showToast('Berhasil keluar. Mengalihkan...', 'success');
            setTimeout(function() {
                // In real app: window.location.href = '/login';
                console.log('Redirecting to login page...');
            }, 1500);
        }
    });
});