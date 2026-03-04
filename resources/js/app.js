import './bootstrap';

import Alpine from 'alpinejs';

// Prevent double-start if something else tried to start Alpine already
if (!window.Alpine) {
  window.Alpine = Alpine;
  Alpine.start();
}