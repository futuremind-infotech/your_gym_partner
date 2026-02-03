import os

files_to_delete = [
    r'c:\xampp\htdocs\your_gym_partner\public\css\sports-theme.css',
    r'c:\xampp\htdocs\your_gym_partner\public\css\sports-login.css',
    r'c:\xampp\htdocs\your_gym_partner\public\css\sports-media.css'
]

for file_path in files_to_delete:
    try:
        if os.path.exists(file_path):
            os.remove(file_path)
            print(f"✓ Deleted: {os.path.basename(file_path)}")
        else:
            print(f"✗ Not found: {os.path.basename(file_path)}")
    except Exception as e:
        print(f"✗ Error deleting {os.path.basename(file_path)}: {str(e)}")

print("\nDone! Sports CSS files removed.")
