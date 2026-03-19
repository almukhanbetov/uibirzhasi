const sidebar = document.getElementById('sidebar')
  const overlay = document.getElementById('overlay')

  function openSidebar() {
    sidebar.classList.remove('-translate-x-full')
    overlay.classList.remove('hidden')
    document.body.classList.add('overflow-hidden')
  }

  function closeSidebar() {
    sidebar.classList.add('-translate-x-full')
    overlay.classList.add('hidden')
    document.body.classList.remove('overflow-hidden')
  }

  const slides = document.querySelectorAll('#slider .slide')
  let currentSlide = 0

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle('opacity-100', i === index)
      slide.classList.toggle('opacity-0', i !== index)
    })
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length
    showSlide(currentSlide)
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length
    showSlide(currentSlide)
  }

  // авто-переключение
  setInterval(nextSlide, 5000)

const studentModal = document.getElementById('studentModal')

  function openStudentModal() {
    studentModal.classList.remove('hidden')
    document.body.classList.add('overflow-hidden')
  }

  function closeStudentModal() {
    studentModal.classList.add('hidden')
    document.body.classList.remove('overflow-hidden')
  }

  // Закрытие по ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeStudentModal()
    }
  })
  