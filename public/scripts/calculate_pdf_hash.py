import sys
import hashlib
import os
from pypdf import PdfReader  # Import PdfReader to extract text


def calculate_pdf_file_hash(pdf_path):
    """
    Calculates the SHA-256 hash of the PDF TEXT CONTENT ONLY (excluding attachments).
    This script now extracts text content and then hashes the text, similar to pdf_extractor.py.

    Args:
        pdf_path (str): Path to the PDF file.

    Returns:
        str: SHA-256 hash of the PDF TEXT CONTENT as a hexadecimal string.
             Returns None and prints an error to stderr if the file cannot be processed.
    """
    if not os.path.exists(pdf_path):
        print(f"Error: PDF file path does not exist: {pdf_path}", file=sys.stderr)
        return None

    try:
        reader = PdfReader(pdf_path)  # Use PdfReader to read the PDF
        pdf_text_content = ""
        for page in reader.pages:
            pdf_text_content += page.extract_text()  # Extract text content page by page

        pdf_content_hash = hashlib.sha256(
            pdf_text_content.encode("utf-8")
        ).hexdigest()  # Hash TEXT CONTENT

        return pdf_content_hash  # Return hash of text content

    except Exception as e:
        print(f"Error processing PDF to calculate content hash: {e}", file=sys.stderr)
        return None


if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python calculate_pdf_hash.py <pdf_file_path>", file=sys.stderr)
        sys.exit(1)

    pdf_file_path = sys.argv[1]
    pdf_file_hash_value = calculate_pdf_file_hash(pdf_file_path)

    if pdf_file_hash_value:
        print(pdf_file_hash_value)  # Print the hash to standard output
    else:
        sys.exit(1)  # Exit with an error code if hash calculation failed
