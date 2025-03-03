import sys
import json
from pathlib import Path
from pypdf import PdfWriter, PdfReader
import logging

# Configure logging
logging.basicConfig(
    filename="attach_file.log",
    level=logging.ERROR,
    format="%(asctime)s - %(levelname)s - %(filename)s - %(lineno)d - %(message)s",
)


def attach_file_to_pdf(input_pdf_path, json_file_path, output_pdf_path):
    try:
        with open(input_pdf_path, "rb") as input_pdf_file:
            reader = PdfReader(input_pdf_file)
            writer = PdfWriter()
            for page in reader.pages:
                writer.add_page(page)

        with open(json_file_path, "rb") as json_file:
            json_data = json_file.read()

        writer.add_attachment(
            Path(json_file_path).name, json_data
        )  # Directly use json_data

        with open(output_pdf_path, "wb") as output_pdf_file:
            writer.write(output_pdf_file)

    except FileNotFoundError:
        logging.exception("Input PDF or JSON file not found.")
        raise
    except Exception as e:
        logging.exception("An error occurred during PDF attachment:")
        raise


if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python attach_file.py <input_pdf> <json_file> <output_pdf>")
        sys.exit(1)
    input_pdf_path = sys.argv[1]
    json_file_path = sys.argv[2]
    output_pdf_path = sys.argv[3]

    attach_file_to_pdf(input_pdf_path, json_file_path, output_pdf_path)
