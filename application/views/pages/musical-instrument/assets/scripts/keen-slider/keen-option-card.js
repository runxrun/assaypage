
var slider = new KeenSlider(
  "#keen-slider-card",
  {
    loop: true,
    rtl: false,
    breakpoints: {
      "(min-width: 1441px)": {
        slides: {
          perView: 4,
          spacing: 20,
        },
      },
      "(max-width: 1440px)": {
        slides: {
          perView: 4,
          spacing: 20,
        },
      },
      "(max-width: 1200px)": {
        slides: {
          perView: 3,
          spacing: 20,
        },
      },
      "(max-width: 800px)": {
        slides: {
          perView: 2,
          spacing: 20,
        },
      },
      "(max-width: 600px)": {
        slides: {
          perView: 1,
          spacing: 20,
        },
      },
    },
  },
  [navigation]
);






// var slider = new KeenSlider("#keen-slider-thumb")
// var thumbnails = new KeenSlider(
//   "#thumbnails",
//   {
//     initial: 0,
//     slides: {
//       perView: 5,
//       spacing: 5,
//     },
//   },
//   [ThumbnailPlugin(this.slider)]
// )