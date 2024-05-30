import pdfplumber

def pdf_to_text(pdf_path, txt_path):
    with pdfplumber.open(pdf_path) as pdf:
        all_text = ''
        for page in pdf.pages:
            text = page.extract_text()
            if text:
                all_text += text + '\n'

    with open(txt_path, 'w', encoding='utf-8') as txt_file:
        txt_file.write(all_text)

# This section can be used to test the function locally
if __name__ == "__main__":
    import sys
    if len(sys.argv) != 3:
        print("Usage: python pdf_to_text.py <input_pdf_path> <output_txt_path>")
    else:
        pdf_to_text(sys.argv[1], sys.argv[2])
