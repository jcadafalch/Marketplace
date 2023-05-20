const sliders = document.querySelectorAll('.slider');

sliders.forEach(function(slider) {
  const group = slider.querySelector('.slide_group');
  const slides = slider.querySelectorAll('.slide');
  const bulletArray = [];
  let currentIndex = 0;
  let timeout;

  function move(newIndex) {
    let animateLeft, slideLeft;

    if (group.classList.contains('animated') || currentIndex === newIndex) {
      return;
    }

    bulletArray[currentIndex].classList.remove('active');
    bulletArray[newIndex].classList.add('active');

    if (newIndex > currentIndex) {
      slideLeft = '100%';
      animateLeft = '-100%';
    } else {
      slideLeft = '-100%';
      animateLeft = '100%';
    }

    slides[newIndex].style.display = 'block';
    slides[newIndex].style.left = slideLeft;

    group.classList.add('animated');
    group.style.left = animateLeft;

    setTimeout(function() {
      slides[currentIndex].style.display = 'none';
      slides[newIndex].style.left = 0;
      group.style.left = 0;
      group.classList.remove('animated');
      currentIndex = newIndex;
    }, 500);
  }

  slider.querySelectorAll('.next_btn').forEach(function(button) {
    button.addEventListener('click', function() {
      if (currentIndex < (slides.length - 1)) {
        move(currentIndex + 1);
      } else {
        move(0);
      }
    });
  });

  slider.querySelectorAll('.previous_btn').forEach(function(button) {
    button.addEventListener('click', function() {
      if (currentIndex !== 0) {
        move(currentIndex - 1);
      } else {
        move(slides.length - 1);
      }
    });
  });

  slides.forEach(function(slide, index) {
    const button = document.createElement('a');
    button.classList.add('slide_btn');
    button.textContent = '•';

    if (index === currentIndex) {
      button.classList.add('active');
    }

    button.addEventListener('click', function() {
      move(index);
    });

    slider.parentElement.querySelectorAll('.slide_buttons').forEach(function(slideButton) {
      slideButton.appendChild(button);
    })
    bulletArray.push(button);
  });
});
