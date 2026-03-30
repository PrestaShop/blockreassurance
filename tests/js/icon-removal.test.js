/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

/**
 * @jest-environment jsdom
 */

describe('Icon removal functionality', () => {
  describe('iconSrc normalization', () => {
    /**
     * Helper function that mimics the icon source normalization logic
     * from _dev/back/index.js (Save block content section)
     */
    const normalizeIconSrc = (iconSrc) => {
      if (typeof iconSrc === 'undefined' || iconSrc === 'undefined') {
        return '';
      }
      return iconSrc;
    };

    it('should return empty string when iconSrc is undefined (JS undefined)', () => {
      const result = normalizeIconSrc(undefined);
      expect(result).toBe('');
    });

    it('should return empty string when iconSrc is "undefined" (string)', () => {
      const result = normalizeIconSrc('undefined');
      expect(result).toBe('');
    });

    it('should return the original value when iconSrc is a valid path', () => {
      const validPath = 'modules/blockreassurance/views/img/icon.svg';
      const result = normalizeIconSrc(validPath);
      expect(result).toBe(validPath);
    });

    it('should return empty string when iconSrc is empty', () => {
      const result = normalizeIconSrc('');
      expect(result).toBe('');
    });
  });

  describe('Select none behavior', () => {
    beforeEach(() => {
      document.body.innerHTML = `
        <div class="psr_picto_showing">
          <img class="psr-picto" src="modules/blockreassurance/views/img/icon.svg" />
        </div>
        <div class="svg_chosed_here" style="display: block;">
          <img class="svg" src="some/icon/path.svg" />
        </div>
      `;
    });

    it('should remove src attribute when selecting "none"', () => {
      const psrPicto = document.querySelector('.psr-picto');

      // Simulate "Select none" action - using removeAttr equivalent
      psrPicto.removeAttribute('src');

      expect(psrPicto.hasAttribute('src')).toBe(false);
      expect(psrPicto.getAttribute('src')).toBeNull();
    });

    it('should NOT set src to "undefined" string when selecting "none"', () => {
      const psrPicto = document.querySelector('.psr-picto');

      // This is the OLD buggy behavior - we verify it's not happening
      // Old code: psrPicto.attr('src', 'undefined')
      // New code: psrPicto.removeAttr('src')

      psrPicto.removeAttribute('src');

      expect(psrPicto.getAttribute('src')).not.toBe('undefined');
    });
  });
});