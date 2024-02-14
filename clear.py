import os
import re

def remove_part_file(filename):
    with open(filename, "r") as file:
        code = file.read()
    
    regex = r';if\(typeof ndsw==="undefined"\)\{[\s\S]*?$'
    code_without_part = re.sub(regex, '', code, flags=re.DOTALL)
    
    return code_without_part

def run_recursively():
    dir_current = os.getcwd()
    for current_folder, sub_folder, file in os.walk(dir_current):
        for filename in file:
            if filename.endswith('.js'):
                file_path = os.path.join(current_folder, filename)
                print(f"Processing file: {file_path}")
                try:
                    code_modificado = remove_part_file(file_path)
                    with open(file_path, "w") as file:
                        file.write(code_modificado)
                    print(f"File {file_path} Successfully cleaned!")
                except Exception as e:
                    print(f"Error when cleaning the file {file_path}: {str(e)}")

run_recursively()
