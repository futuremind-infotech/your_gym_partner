import os

# List of CSS files to delete
files_to_delete = [
    r"c:\xampp\htdocs\your_gym_partner\public\css\sports-theme.css",
    r"c:\xampp\htdocs\your_gym_partner\public\css\sports-login.css",
    r"c:\xampp\htdocs\your_gym_partner\public\css\sports-media.css"
]

deleted_count = 0
not_found_count = 0

print("Starting CSS file deletion process...\n")

for file_path in files_to_delete:
    try:
        if os.path.exists(file_path):
            os.remove(file_path)
            print(f"✓ Successfully deleted: {file_path}")
            deleted_count += 1
        else:
            print(f"✗ File not found: {file_path}")
            not_found_count += 1
    except Exception as e:
        print(f"✗ Error deleting {file_path}: {e}")
        not_found_count += 1

print(f"\n--- Summary ---")
print(f"Total files deleted: {deleted_count}")
print(f"Files not found or errors: {not_found_count}")
print(f"Total attempted: {len(files_to_delete)}")
