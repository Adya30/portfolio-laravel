import fs from 'fs';

function stripJsComments(code) {
  let result = '';
  let i = 0;
  const len = code.length;

  while (i < len) {
    if (code[i] === "'" || code[i] === '"') {
      const quote = code[i];
      result += code[i++];
      while (i < len && code[i] !== quote) {
        if (code[i] === '\\') { result += code[i++]; }
        if (i < len) result += code[i++];
      }
      if (i < len) result += code[i++];
      continue;
    }

    if (code[i] === '`') {
      result += code[i++];
      while (i < len && code[i] !== '`') {
        if (code[i] === '\\') { result += code[i++]; }
        if (i < len) result += code[i++];
      }
      if (i < len) result += code[i++];
      continue;
    }

    if (code[i] === '/' && i + 1 < len && code[i + 1] === '/') {
      while (i < len && code[i] !== '\n') i++;
      continue;
    }

    if (code[i] === '/' && i + 1 < len && code[i + 1] === '*') {
      i += 2;
      while (i < len && !(code[i] === '*' && i + 1 < len && code[i + 1] === '/')) i++;
      i += 2;
      continue;
    }

    result += code[i++];
  }

  return result;
}

// Test with the small snippet
const test = '/* === */\n// hello\nvar x = 1; // inline\n';
console.log('Test input:', JSON.stringify(test));
console.log('Test output:', JSON.stringify(stripJsComments(test)));

// Test with actual file
const code = fs.readFileSync('resources/js/app.js', 'utf8');
console.log('\nOriginal length:', code.length);

// Check what's around position of the first remaining comment
const idx = code.indexOf('/* ==========');
console.log('First /* ========= at index:', idx);
console.log('Context:', JSON.stringify(code.substring(idx - 20, idx + 50)));

const stripped = stripJsComments(code);
console.log('\nStripped length:', stripped.length);

// Check if comments remain
const remaining = stripped.match(/(\/\/[^\n]*|\/\*[\s\S]*?\*\/)/g) || [];
console.log('Remaining comment patterns:', remaining.length);
remaining.slice(0, 5).forEach(r => console.log('  ', JSON.stringify(r.substring(0, 80))));

// Check specifically the problematic area
const stripIdx = stripped.indexOf('/* ==========');
console.log('\n/* ========= in stripped at index:', stripIdx);
