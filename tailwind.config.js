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
        'deep-purple': 'rgb(103,58,183)',
      },
      fontFamily: {
        sans: ['Poppins', 'Poppins'],
        serif: ['Poppins', 'Poppins'],
        mono: ['Poppins', 'Poppins'],
        display: ['Poppins'],
        body: ['Poppins'],
      },
    },
  },
  plugins: [],
}
