/**
 * Gauteng-only rebuild. Prefer:
 *   node scripts/build-education-districts.js
 */
const { main } = require('./build-education-districts');

main('GT').catch((err) => {
  console.error(err);
  process.exit(1);
});
