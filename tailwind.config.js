/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    
    extend: {
      colors: {
        'white': '#FFF',
        'blue': '#0d8187',
        'black': '#303030',
      },
      fontFamily: {
        julius: ['Bellota', 'serif'],
      }
    },
  },
  plugins: [],
}

