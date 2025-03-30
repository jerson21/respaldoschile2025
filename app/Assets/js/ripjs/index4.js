new Splide("#splide_1", {
  perPage: 6,
  perMove: 1,
  breakpoints: {
    768: {
      perPage: 3,
    },
  },
  rewind: true,
  type: "loop",
  autoplay: true,
  pagination: false,
}).mount();
