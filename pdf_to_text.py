import pdfplumber
import sys
import os

def pdf_to_text(pdf_path, txt_path):
    with pdfplumber.open(pdf_path) as pdf:
        text = ''
        for page in pdf.pages:
            text += page.extract_text()
        with open(txt_path, 'w', encoding='utf-8') as f:
            f.write(text)
    os.remove(pdf_path)  # Smaže PDF soubor po konverzi

if __name__ == "__main__":
    pdf_path = sys.argv[1]
    txt_path = sys.argv[2]
    pdf_to_text(pdf_path, txt_path)
