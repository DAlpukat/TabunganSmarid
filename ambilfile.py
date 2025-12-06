import os
import shutil

# Menentukan direktori proyek Laravel Anda
base_dir = r'C:\Users\ASUS\Downloads\Compressed\infor\laravel12_breeze'

# Folder yang ingin diproses
folders = [os.path.join(base_dir, 'resources'), 
           os.path.join(base_dir, 'routes'), 
           os.path.join(base_dir, 'database'), 
           os.path.join(base_dir, 'app')]

# Menentukan folder tujuan untuk menyalin file
destination_dir = r'C:\Users\ASUS\Downloads\Compressed\infor\laravel12_breeze\copied_files'

# Membuat folder tujuan jika belum ada
if not os.path.exists(destination_dir):
    os.makedirs(destination_dir)

def get_files_from_folders(folders, destination_dir):
    all_files = []

    for folder in folders:
        # Mengecek apakah folder ada
        if os.path.exists(folder):
            for root, _, files in os.walk(folder):
                for file in files:
                    # Mendapatkan path file relatif
                    file_path = os.path.join(root, file)
                    # Mendapatkan nama file tanpa ekstensi
                    file_name, file_extension = os.path.splitext(file)
                    # Menggunakan nama folder sebagai prefiks untuk memastikan nama file unik
                    folder_name = os.path.basename(root)
                    
                    # Membuat nama file yang unik
                    unique_file_name = f"({folder_name}){file_name}{file_extension}"
                    unique_file_path = os.path.join(destination_dir, unique_file_name)

                    # Menyalin file ke folder tujuan
                    shutil.copy2(file_path, unique_file_path)
                    
                    # Menambahkan file ke dalam list
                    all_files.append(unique_file_name)
    
    return all_files

# Menjalankan fungsi untuk mendapatkan semua file dan menyalinnya
files = get_files_from_folders(folders, destination_dir)

# Menampilkan hasil file yang sudah diproses dan disalin
for file in files:
    print(file)

print(f"Semua file telah disalin ke: {destination_dir}")
