





var slider = new KeenSlider("#keen-slider-thumb")
var thumbnails = new KeenSlider(
  "#thumbnails",
  {
    initial: 0,
    slides: {
      perView: 5,
      spacing: 5,
    },
  },
  [ThumbnailPlugin(this.slider)]
)