const headerMessage = document.querySelector("#headerMessage");

const tl = new TimelineMax();

tl.fromTo(headerMessage, 1, {left:0, opacity:1}, {left:100, opacity:0.5});

