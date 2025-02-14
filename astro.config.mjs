// @ts-check
import { defineConfig } from 'astro/config';

import tailwindcss from '@tailwindcss/vite';

// https://astro.build/config
export default defineConfig({
  site: 'https://notthatninja.github.io',
  base: 'studio-dusio',
  vite: {
    plugins: [tailwindcss()]
  },
});