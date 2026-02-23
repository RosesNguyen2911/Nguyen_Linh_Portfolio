import { aboutAnimation } from "./modules/about-animation.js";
import { casestudyAnimation } from "./modules/casestudy-animation.js";
import { connectAnimation } from "./modules/connect-animation.js";
import { featuredWorks } from "./modules/featured-works.js";
import { homeAnimation } from "./modules/home-animation.js";
import { videoPlayer } from "./modules/video-player.js";
import { workAnimation } from "./modules/works-animation.js";


if(document.body.dataset.page==="home"){
  featuredWorks();
  homeAnimation();
  videoPlayer();
}else if(document.body.dataset.page==="works"){
  workAnimation();
  featuredWorks();
}else if(document.body.dataset.page==="about"){
  aboutAnimation();
}else if(document.body.dataset.page==="connect"){
  connectAnimation();
}else if(document.body.dataset.page==="casestudy"){
  casestudyAnimation();
}

