import { aboutAnimation } from "./modules/about-animation.js";
import { casestudyAnimation } from "./modules/casestudy-animation.js";
import { contactAnimation } from "./modules/contact-animation.js";
import { featuredWorks } from "./modules/featured-works.js";
import { homeAnimation } from "./modules/home-animation.js";
import { videoPlayer } from "./modules/video-player.js";
import { workAnimation } from "./modules/works-animation.js";
import { videoplayerCasestudy } from "./modules/video-player-casestudy.js";
import { contactForm } from "./modules/contact-form.js";


if(document.body.dataset.page==="home"){
  featuredWorks();
  homeAnimation();
  videoPlayer();
}else if(document.body.dataset.page==="works"){
  workAnimation();
  featuredWorks();
}else if(document.body.dataset.page==="about"){
  aboutAnimation();
}else if(document.body.dataset.page==="contact"){
  contactAnimation();
  contactForm();
}else if(document.body.dataset.page==="casestudy"){
  casestudyAnimation();
  videoplayerCasestudy();
}

