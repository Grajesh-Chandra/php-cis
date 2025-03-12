import sys
import json
from pypdf import PdfReader
import os
import base64
import hashlib  # Import the hashlib library for hashing


def extract_pdf_data(pdf_path):
    """
    Extracts text content and attachment information from a PDF file.
    Calculates SHA-256 hash of the PDF content (text only, excluding attachments).

    Args:
        pdf_path (str): Path to the PDF file.

    Returns:
        dict: A dictionary containing 'pdf_content' (text), 'attachments' (list of attachment info),
              and 'pdf_content_hash' (SHA-256 hash of pdf_content).
              Returns None and prints an error to stderr if parsing fails.
    """
    pdf_file = open(pdf_path, "rb")
    print(f"Python script received path: {pdf_path}", file=sys.stderr)
    if not os.path.exists(pdf_path):
        print(f"Error: PDF file path does not exist: {pdf_path}", file=sys.stderr)
        pdf_file.close()
        return None

    try:
        reader = PdfReader(pdf_path)
        pdf_text_content = ""
        for page in reader.pages:
            pdf_text_content += page.extract_text()

        # Calculate SHA-256 hash of the PDF content
        pdf_content_hash = hashlib.sha256(pdf_text_content.encode("utf-8")).hexdigest()
        print(f"SHA-256 hash of PDF content: {pdf_content_hash}", file=sys.stderr)

        attachments_data = []

        if reader.attachments:
            for filename, data in reader.attachments.items():
                # Handle different filename types robustly (as before)
                if isinstance(filename, bytes):
                    try:
                        attachment_filename = filename.decode("utf-8", "ignore")
                    except UnicodeDecodeError:
                        attachment_filename = "filename_decoding_error"
                else:
                    attachment_filename = str(filename)

                attachment_content_base64 = None  # Initialize outside if-else
                content_encoding = "base64"

                if isinstance(data, bytes):
                    attachment_content_base64 = base64.b64encode(data).decode("utf-8")
                elif isinstance(data, list):
                    # Try to handle case where data is a list of bytes (concatenate)
                    try:
                        byte_data = b"".join(
                            data
                        )  # Join list of bytes into single bytes object
                        attachment_content_base64 = base64.b64encode(byte_data).decode(
                            "utf-8"
                        )
                    except TypeError as e:
                        attachment_content_base64 = f"Error processing list content: {e}"  # Error message for list processing
                        content_encoding = "error"  # Indicate encoding error
                        print(
                            f"Error joining byte list for attachment {attachment_filename}: {e}",
                            file=sys.stderr,
                        )  # Log details to stderr

                else:
                    attachment_content_base64 = f"Unexpected attachment content type: {type(data)}"  # Indicate unexpected type
                    content_encoding = "unknown_type"  # Indicate unknown type
                    print(
                        f"Unexpected attachment content type for {attachment_filename}: {type(data)}",
                        file=sys.stderr,
                    )  # Log details to stderr

                attachment_info = {
                    "filename": attachment_filename,
                    "content_base64": attachment_content_base64,  # Will be base64, error msg, or type info
                    "content_encoding": content_encoding,  # "base64", "error", or "unknown_type"
                    "mime_type": None,
                }
                attachments_data.append(attachment_info)

        pdf_file.close()
        return {
            "pdf_content": pdf_text_content,
            "attachments": attachments_data,
            "pdf_content_hash": pdf_content_hash,
        }  # Include hash in response

    except Exception as e:
        pdf_file.close()
        print(f"Error processing PDF: {e}", file=sys.stderr)
        return None


if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python pdf_extractor.py <pdf_file_path>", file=sys.stderr)
        sys.exit(1)

    pdf_file_path = sys.argv[1]
    extraction_result = extract_pdf_data(pdf_file_path)

    if extraction_result:
        print(json.dumps(extraction_result, ensure_ascii=False))
    else:
        sys.exit(1)
