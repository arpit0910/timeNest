import sys

file_path = r'e:\timeNest\resources\views\frontend\pages\home-v2.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
i = 0
while i < len(lines):
    line = lines[i]
    if '<x-frontend-sections.testimonial-section' in line:
        new_lines.append(line.replace('testimonial-section', 'testimonials.full'))
        i += 1
        continue
    
    if '<section class="py-24 lg:py-32 bg-slate-50 relative border-t border-slate-200/60" id="faq"' in line:
        new_lines.append('    <x-frontend-sections.faq.full :faqs="$faqs" />\n')
        # Skip until we find the closing </section> at the same indentation
        # Actually it's line 2626 to 3102.
        while i < len(lines):
            i += 1
            if i >= len(lines):
                break
            if '</section>' in lines[i] and '    </section>' == lines[i].rstrip():
                # wait, let me check the exact indentation of </section> for FAQ.
                # It's at 3102: "    </section>"
                # I will just break on the exact line 3102.
                pass
            if '    </section>' in lines[i] and i > 3000:
                i += 1 # skip the </section> line too
                break
        continue

    new_lines.append(line)
    i += 1

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(new_lines)

print("Done replacing.")
