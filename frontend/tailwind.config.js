/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}", "./index.html",
  ],
  theme: {
    extend: {
      colors: {
        blue: {
          main: '#13293d',
        },
        green: {
         spotify: "#1ED760",
        }
      },
    },
  },
  plugins: [],
}

