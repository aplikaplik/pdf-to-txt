import sys
import os
import pdfplumber

def pdf_to_text(pdf_path, txt_path):
    # Ensure the directory for the txt file exists
    os.makedirs(os.path.dirname(txt_path), exist_ok=True)
    
    # Convert PDF to text
    with pdfplumber.open(pdf_path) as pdf:
        text = ""
        for page in pdf.pages:
            text += page.extract_text() + "\n"
    
    # Write text to the output file
    with open(txt_path, 'w', encoding='utf-8') as f:
        f.write(text)

    # Remove the PDF file after conversion
    os.remove(pdf_path)

if __name__ == "__main__":
    pdf_path = sys.argv[1]
    txt_path = sys.argv[2]
    pdf_to_text(pdf_path, txt_path)

