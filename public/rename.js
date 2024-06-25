;[...document.querySelectorAll('link')].forEach((e) => {
  let href = e.getAttribute('href')
  console.log(href)
  e.setAttribute(href.replace('http://', 'https://'))
})
