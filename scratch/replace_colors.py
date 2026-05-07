import os

def replace_in_files(directory, target, replacement):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.blade.php'):
                path = os.path.join(root, file)
                with open(path, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                if target in content:
                    new_content = content.replace(target, replacement)
                    with open(path, 'w', encoding='utf-8') as f:
                        f.write(new_content)
                    print(f"Updated: {path}")

# Primary replacements
replace_in_files('resources/views/pembeli', '#F53003', '#FFB800')
replace_in_files('resources/views/pembeli', '#FF4433', '#10B981')
replace_in_files('resources/views/pembeli', 'rgba(245, 48, 3,', 'rgba(255, 184, 0,')
replace_in_files('resources/views/pembeli', 'rgba(245,48,3,', 'rgba(255,184,0,')
