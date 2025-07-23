import pyodbc
import pandas as pd

def read_mdb_file(mdb_path, password=None):
    try:
        # String koneksi untuk file MDB
        if password:
            conn_str = (
                r'DRIVER={Microsoft Access Driver (*.mdb, *.accdb)};'
                r'DBQ=' + mdb_path + ';'
                r'PWD=' + password + ';'
            )
        else:
            conn_str = (
                r'DRIVER={Microsoft Access Driver (*.mdb, *.accdb)};'
                r'DBQ=' + mdb_path + ';'
            )
        
        # Membuat koneksi
        conn = pyodbc.connect(conn_str)
        cursor = conn.cursor()
        
        # Mendapatkan daftar tabel
        tables = cursor.tables(tableType='TABLE')
        table_names = [table.table_name for table in tables]
        
        print("Daftar Tabel dalam Database:")
        for table in table_names:
            print(f"- {table}")
        
        # Membaca isi tabel pertama sebagai contoh
        if table_names:
            sample_table = table_names[0]
            print(f"\nIsi tabel '{sample_table}':")
            
            # Menggunakan pandas untuk menampilkan data
            df = pd.read_sql(f'SELECT * FROM [{sample_table}]', conn)
            print(df.head())
        
        # Tutup koneksi
        conn.close()
        
    except Exception as e:
        print("Error:", e)

# Ganti dengan path file HITFPTA.mdb Anda
mdb_file_path = r'C:\path\to\your\HITFPTA.mdb'

# Jika ada password, ganti None dengan password-nya
read_mdb_file(mdb_file_path, password=None)