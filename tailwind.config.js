/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        brand: '#E08D79',
        icon: '#fc9630',
      },
      fontFamily: {
        sans: ['Merriweather', 'Merriweather'],
        serif: ['Merriweather', 'Merriweather'],
        mono: ['Merriweather', 'Merriweather'],
        display: ['Merriweather'],
        body: ['Merriweather'],
      },
    },
  },
  plugins: [],
}
