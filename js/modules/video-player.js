export function videoPlayer(){
// I used const because these elements stay the same
const vid = document.querySelector(".portfolio-video");
const playMid = document.querySelector(".btn-center-play");
const playBtn = document.querySelector(".btn-playpause");
const againBtn = document.querySelector(".btn-replay");
const timeTxt = document.querySelector(".time-display");

// I grouped the video progress parts
const barBox = document.querySelector(".progress-container");
const barFill = document.querySelector(".progress-bar");
const barDot = document.querySelector(".progress-thumb");

// I grouped the volume parts
const soundBox = document.querySelector(".volume-track");
const soundFill = document.querySelector(".volume-bar");
const soundDot = document.querySelector(".volume-thumb");
const soundIcon = document.querySelector(".volume-icon");

// I also have buttons for settings
const gearBtn = document.querySelector(".btn-setting");
const gearMenu = document.querySelector(".setting-menu");

// I also added a button for fullscreen
const fullscreenBtn = document.querySelector(".btn-fullscreen");

// I selected the video wrapper so I can detect hover
const vidBox = document.querySelector(".video-wrapper");
// I selected the controls container to show and hide it
const controls = document.querySelector(".video-controls");


// I made simple flags to know when the user is dragging
let holdBar = false;
let holdSound = false;
let isFullscreen = false;


// ====== PLAY / PAUSE ======
function doPlay() {
  if (vid.paused) {
    vid.play();
    playMid.classList.add("hidden"); // I hide the big play button
    playBtn.innerHTML = '<i class="fa-solid fa-pause"></i>'; // I change the icon
  } else {
    vid.pause();
    playMid.classList.remove("hidden"); // I show the big play button again
    playBtn.innerHTML = '<i class="fa-solid fa-play"></i>';
  }
}


// ====== REPLAY ======
function doAgain() {
  vid.currentTime = 0;
  vid.play();
  playMid.classList.add("hidden");
  playBtn.innerHTML = '<i class="fa-solid fa-pause"></i>';
}


// ====== UPDATE TIME BAR ======
function showTime() {
  // I stop updates while dragging so it doesn’t jump
  if (!holdBar && vid.duration) {
    const percent = (vid.currentTime / vid.duration) * 100;
    barFill.style.width = percent + "%";
    barDot.style.left = percent + "%";

    // I made a simple timer format like 0:00
    const m = Math.floor(vid.currentTime / 60);
    const s = Math.floor(vid.currentTime % 60);
    const tm = Math.floor(vid.duration / 60);
    const ts = Math.floor(vid.duration % 60);

    const cur = m + ":" + (s < 10 ? "0" + s : s);
    const total = tm + ":" + (ts < 10 ? "0" + ts : ts);
    timeTxt.textContent = cur + " / " + total;
  }
}


// ====== VOLUME CONTROL ======
function setSound(mouseX) {
  const box = soundBox.getBoundingClientRect();
  let pos = mouseX - box.left;

  // I keep position inside the bar
  if (pos < 0) pos = 0;
  if (pos > box.width) pos = box.width;

  const percent = pos / box.width;
  vid.volume = percent;
  vid.muted = false;

  // I update the blue bar and white dot
  soundFill.style.width = percent * 100 + "%";
  soundDot.style.left = percent * 100 + "%";

  changeIcon(); // I call another function to update the icon
}


// ====== MUTE / UNMUTE ======
function muteSound() {
  vid.muted = !vid.muted;
  changeIcon();

  if (vid.muted) {
    soundFill.style.width = "0%";
    soundDot.style.left = "0%";
  } else {
    soundFill.style.width = vid.volume * 100 + "%";
    soundDot.style.left = vid.volume * 100 + "%";
  }
}


// ====== ICON CHANGE ======
function changeIcon() {
  if (vid.muted || vid.volume === 0) {
    soundIcon.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
  } else if (vid.volume < 0.5) {
    soundIcon.innerHTML = '<i class="fa-solid fa-volume-low"></i>';
  } else {
    soundIcon.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
  }
}


// ====== PLAYBACK SPEED ======
function showMenu() {
  gearMenu.classList.toggle("hidden");
}

function pickSpeed(e) {
  const speed = parseFloat(e.target.dataset.speed);
  vid.playbackRate = speed;
  gearMenu.classList.add("hidden");
}


// ====== FULLSCREEN MODE ======
function handleFullscreenToggle() {
  if (!isFullscreen) {
    // I used requestFullscreen to make the video big
    if (vid.requestFullscreen) {
      vid.requestFullscreen();
    } else if (vid.webkitRequestFullscreen) {
      vid.webkitRequestFullscreen(); // for Safari
    } else if (vid.msRequestFullscreen) {
      vid.msRequestFullscreen(); // for Edge
    }
    isFullscreen = true;
    fullscreenBtn.innerHTML = '<i class="fa-solid fa-compress"></i>';
  } else {
    // I used exitFullscreen to go back to normal
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
    isFullscreen = false;
    fullscreenBtn.innerHTML = '<i class="fa-solid fa-expand"></i>';
  }
}


// ====== DRAGGING BEHAVIOUR ======
function startHold(e) {
  // I allow dragging anywhere on the video progress bar (not only the thumb)
  if (e.target.closest(".progress-container")) {
    holdBar = true;
  }

  // Volume dragging remains the same
  if (e.target.closest(".volume-thumb") || e.target.closest(".volume-track")) {
    holdSound = true;
  }
}

function moveHold(e) {
  // Video progress drag
  if (holdBar) {
    const box = barBox.getBoundingClientRect();
    let pos = e.clientX - box.left;

    if (pos < 0) pos = 0;
    if (pos > box.width) pos = box.width;

    const percent = pos / box.width;
    vid.currentTime = vid.duration * percent;

    // I update the UI instantly while dragging
    barFill.style.width = percent * 100 + "%";
    barDot.style.left = percent * 100 + "%";
  }

  // Volume drag works as before
  if (holdSound) {
    setSound(e.clientX);
  }
}

function stopHold() {
  holdBar = false;
  holdSound = false;
}

/* ====== SHOW / HIDE CONTROLS ======
   I made this so the controls only appear when I hover the video,
   similar to YouTube's behavior, but simpler.
*/
function showControls() {
    controls.classList.add("show");
  }
  
  function hideControls() {
    controls.classList.remove("show");
  }


// ====== EVENT LISTENERS ======
// I put all event listeners at the end, like in the coding guide
vid.addEventListener("click", doPlay);
playMid.addEventListener("click", doPlay);
playBtn.addEventListener("click", doPlay);
againBtn.addEventListener("click", doAgain);
vid.addEventListener("timeupdate", showTime);

// Jump to any part when clicking progress bar
barBox.addEventListener("click", function (e) {
  const box = barBox.getBoundingClientRect();
  let pos = e.clientX - box.left;
  if (pos < 0) pos = 0;
  if (pos > box.width) pos = box.width;
  const percent = pos / box.width;
  vid.currentTime = vid.duration * percent;
});

// Volume bar click
soundBox.addEventListener("click", function (e) {
  setSound(e.clientX);
});

// I used named handlers for clarity
soundIcon.addEventListener("click", muteSound);
gearBtn.addEventListener("click", showMenu);
fullscreenBtn.addEventListener("click", handleFullscreenToggle);

// I made each menu item clickable for speed change
gearMenu.querySelectorAll("li").forEach(function (li) {
  li.addEventListener("click", pickSpeed);
});

// I added listeners for dragging video and volume
document.addEventListener("mousedown", startHold);
document.addEventListener("mousemove", moveHold);
document.addEventListener("mouseup", stopHold);

vidBox.addEventListener("mouseenter", showControls);
vidBox.addEventListener("mouseleave", hideControls);

}
