/**
 * Regenerates .github/social-preview.png — the 1280x640 card GitHub shows when this
 * repository is shared on social, in chat and in search previews.
 *
 * A bare screenshot of a WordPress homepage says nothing in a feed: it does not tell a
 * reader which theme it is, that it is free, or even that it is WordPress. So the card
 * splits — the facts on the left, the live demo framed on the right — rather than laying
 * type over a design that already has its own headline.
 *
 * The demo is captured live from https://colorlibhub.com/dazzling/, so this needs a
 * network connection and reflects whatever the demo currently looks like.
 *
 * 1280x640 at deviceScaleFactor 1. Do NOT render at 2x: GitHub caps the upload at 1 MB
 * and the extra pixels buy nothing at the size this is ever displayed.
 *
 * There is no API for uploading it — not REST, not GraphQL, not gh. It is browser-only:
 * Settings -> General -> Social preview -> Edit -> Upload an image.
 *
 * Playwright is not a dependency of a WordPress theme, so point at an install elsewhere.
 * ESM will not import a bare directory — give it the entry file, not the package folder:
 *
 *   PLAYWRIGHT_PATH="/path/to/node_modules/playwright/index.js" node .github/social-preview.mjs
 */

import { writeFileSync, unlinkSync } from 'node:fs';
import { fileURLToPath, pathToFileURL } from 'node:url';
import { dirname, join } from 'node:path';

const here = dirname(fileURLToPath(import.meta.url));
// Playwright is CommonJS; imported by path its exports land on `default`, not as named ones.
const pw = await import(process.env.PLAYWRIGHT_PATH
  ? pathToFileURL(process.env.PLAYWRIGHT_PATH).href
  : 'playwright');
const { chromium } = pw.chromium ? pw : pw.default;

const DEMO = 'https://colorlibhub.com/dazzling/';
// Which slide the hero settles on. The demo runs WordPress theme-unit-test content, so
// every slide is titled "Markup: ...": slide 0's excerpt is a wall of ~`!@#$%^&*() that
// reads as a broken page at card size, and slide 1's is a run of bare heading words.
// Slide 2 is the only one whose excerpt is ordinary prose. Revisit if the demo's
// featured posts are ever replaced with real content.
const SLIDE = 2;
// Third-party beacons only slow the capture down and never appear in it.
const BLOCK = /googletagmanager|google-analytics|doubleclick|facebook|hotjar|clarity\.ms|stats\.wp\.com/;

const browser = await chromium.launch();

/* ---------- 1. capture the live demo ---------- */
const ctx = await browser.newContext({
  viewport: { width: 1280, height: 900 },
  deviceScaleFactor: 2,
  // FlexSlider autoplays a crossfade. Without this the hero is caught mid-transition and
  // renders as a ghosted double exposure with two captions overlapping.
  reducedMotion: 'reduce',
});
await ctx.route('**/*', (r) => (BLOCK.test(r.request().url()) ? r.abort() : r.continue()));
const demo = await ctx.newPage();
await demo.goto(DEMO, { waitUntil: 'domcontentloaded', timeout: 45000 });
await demo.waitForLoadState('load', { timeout: 30000 }).catch(() => {});
for (const sel of ['#cn-accept-cookie', '.cli_action_button', '.cc-dismiss', 'button:has-text("Accept")']) {
  const el = demo.locator(sel).first();
  if ((await el.count().catch(() => 0)) && (await el.isVisible().catch(() => false))) {
    await el.click().catch(() => {});
  }
}
// Nudge lazy images into loading, then return to the top. Never await an image: one that
// neither loads nor errors would hang the script forever.
await demo.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
await demo.waitForTimeout(1800);
await demo.evaluate(() => window.scrollTo(0, 0));
await demo.waitForTimeout(2500);
// Belt and braces on top of reduced motion: pin FlexSlider to its first slide.
await demo.evaluate((keep) => {
  const pin = (slides) => slides.forEach((el, i) => {
    el.style.setProperty('transition', 'none', 'important');
    el.style.setProperty('opacity', i === keep ? '1' : '0', 'important');
    el.style.setProperty('display', i === keep ? 'block' : 'none', 'important');
  });
  const flex = document.querySelector('.flexslider ul.slides');
  if (flex) pin(Array.from(flex.querySelectorAll(':scope > li')));
}, SLIDE);
await demo.waitForTimeout(600);
const shot = (await demo.screenshot()).toString('base64');
const loaded = await demo.evaluate(
  () => `${Array.from(document.images).filter((i) => i.complete && i.naturalWidth).length}/${document.images.length}`
);
console.log(`captured ${DEMO} — images ${loaded}`);
await ctx.close();

/* ---------- 2. compose the card ---------- */
const html = `<!doctype html><meta charset="utf-8">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
  *{margin:0;padding:0;box-sizing:border-box}
  body{width:1280px;height:640px;overflow:hidden;
       font-family:Inter,-apple-system,"Helvetica Neue",Arial,sans-serif;
       -webkit-font-smoothing:antialiased}
  .card{position:relative;width:1280px;height:640px;background:#0b1a16;overflow:hidden}
  /* faint graph paper, so the flat panel behind the type is not dead space */
  .grid{position:absolute;inset:0;
        background-image:linear-gradient(rgba(255,255,255,.032) 1px,transparent 1px),
                         linear-gradient(90deg,rgba(255,255,255,.032) 1px,transparent 1px);
        background-size:44px 44px}
  .glow{position:absolute;left:-300px;top:-340px;width:940px;height:940px;border-radius:50%;
        background:radial-gradient(circle,rgba(31,166,122,.32) 0%,transparent 62%)}
  .body{position:absolute;left:78px;top:0;width:590px;height:640px;
        display:flex;flex-direction:column;justify-content:center}
  .brand{display:flex;align-items:center;gap:16px;margin-bottom:30px}
  .mark{width:52px;height:52px;border-radius:15px;background:#1FA67A;
        display:grid;place-items:center;color:#fff;font-size:26px;font-weight:700;
        box-shadow:0 8px 24px rgba(31,166,122,.32)}
  .brand b{font-size:31px;font-weight:600;color:#fff;letter-spacing:-.01em}
  h1{font-size:56px;line-height:1.09;font-weight:700;color:#fff;letter-spacing:-.028em}
  h1 i{font-style:normal;color:#4FD9A6;display:block}
  p{margin-top:20px;font-size:21px;line-height:1.5;color:rgba(255,255,255,.58);max-width:520px}
  .chips{display:flex;gap:11px;margin-top:36px}
  .chip{font-size:15px;font-weight:500;white-space:nowrap;padding:9px 17px;border-radius:999px;
        border:1px solid rgba(255,255,255,.17);color:rgba(255,255,255,.78)}
  .chip--on{border-color:#1FA67A;color:#4FD9A6;background:rgba(31,166,122,.28)}
  /* the frame runs off the right edge on purpose — a fully contained rectangle reads
     like a pasted thumbnail, a bleeding one like a window onto a bigger thing */
  .shot{position:absolute;left:690px;top:86px;width:650px;height:468px;border-radius:16px;
        border:1px solid rgba(255,255,255,.13);box-shadow:0 34px 80px rgba(0,0,0,.55);
        background:url(data:image/png;base64,${shot}) top center / cover no-repeat #fff}
</style>
<div class="card">
  <div class="grid"></div><div class="glow"></div>
  <div class="body">
    <div class="brand"><div class="mark">D</div><b>Dazzling</b></div>
    <h1>A flat design<i>WordPress theme</i></h1>
    <p>Bootstrap 3, a full-width featured slider, four sidebar layouts and 18 translations.</p>
    <div class="chips"><span class="chip chip--on">Free &amp; GPLv2</span><span class="chip">WooCommerce ready</span><span class="chip">600k+ downloads</span></div>
  </div>
  <div class="shot"></div>
</div>`;

const tmp = join(here, '.social-preview.tmp.html');
writeFileSync(tmp, html);
const page = await browser.newPage({ viewport: { width: 1280, height: 640 }, deviceScaleFactor: 1 });
await page.goto('file://' + tmp, { waitUntil: 'networkidle' });
await page.evaluate(() => document.fonts.ready);
await page.waitForTimeout(500);
await page.screenshot({ path: join(here, 'social-preview.png') });
await browser.close();
unlinkSync(tmp);

console.log('wrote .github/social-preview.png (1280x640)');
