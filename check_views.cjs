const fs = require('fs');
const { execSync } = require('child_process');
const files = execSync('ls storage/framework/views/*.php', {encoding:'utf8'}).trim().split('\n');
let found = false;
for (const f of files) {
  const c = fs.readFileSync(f, 'utf8');
  const lines = c.split('\n');
  for (let i = 0; i < lines.length; i++) {
    // Look for lines containing 'humor' - these are the problematic lines
    if (lines[i].includes('humor') && lines[i].includes('bad')) {
      const line = lines[i];
      console.log(f + ':' + (i+1) + ': ' + line.trim().substring(0, 150));
      // Check for ASCII apostrophe inside single-quoted string
      let inSingle = false;
      for (let j = 0; j < line.length; j++) {
        if (line.charCodeAt(j) === 0x27) {
          console.log('  -> ASCII apostrophe (0x27) at position ' + j);
          found = true;
        }
      }
    }
  }
}
if (!found) console.log('No ASCII apostrophes found in humor lines');
