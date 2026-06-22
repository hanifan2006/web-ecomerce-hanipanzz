// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
  const images = document.querySelectorAll('.pcard-img img');
  images.forEach(img => {
    img.onerror = function() {
      // Jika gambar gagal, tampilkan emoji fallback
      const parent = this.parentElement;
      const emoji = parent.dataset.emoji || '💻';
      this.style.display = 'none';
      
      // Jika belum ada span emoji, buat satu
      if (!parent.querySelector('.pcard-emoji')) {
        const emojiSpan = document.createElement('span');
        emojiSpan.className = 'pcard-emoji';
        emojiSpan.textContent = emoji;
        parent.appendChild(emojiSpan);
      }
    };
    
    // Jika gambar gagal memuat dalam 3 detik
    setTimeout(() => {
      if (!img.complete || img.naturalHeight === 0) {
        img.onerror?.();
      }
    }, 3000);
  });
  
  // Smooth scroll behavior
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
});
