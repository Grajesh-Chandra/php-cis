import sys
import json
from pathlib import Path
from pypdf import PdfWriter, PdfReader
import logging

logging.basicConfig(
    filename="attach_file.log",
    level=logging.ERROR,
    format="%(asctime)s - %(levelname)s - %(filename)s - %(lineno)d - %(message)s",
)


def attach_files_to_pdf(input_pdf_path, json_file_paths, output_pdf_path):
    try:
        with open(input_pdf_path, "rb") as input_pdf_file:
            reader = PdfReader(input_pdf_file)
            writer = PdfWriter()
            for page in reader.pages:
                writer.add_page(page)

        for json_file_path in json_file_paths:
            json_file_path = json_file_path.strip()
            if not json_file_path:
                continue
            json_file_path = Path(json_file_path)

            if not json_file_path.exists():
                logging.error(f"JSON file not found: {json_file_path}")
                continue

            try:
                with open(json_file_path, "rb") as json_file:
                    json_data = json_file.read()
                writer.add_attachment(json_file_path.name, json_data)
            except FileNotFoundError:
                logging.error(
                    f"JSON file not found during attachment: {json_file_path}"
                )
            except Exception as e:
                logging.exception(f"Error attaching {json_file_path}: {e}")

        with open(output_pdf_path, "wb") as output_pdf_file:
            writer.write(output_pdf_file)

    except FileNotFoundError:
        logging.exception("Input PDF not found.")
        raise
    except Exception as e:
        logging.exception("An error occurred during PDF attachment process:")
        raise


if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(
            "Usage: python attach_file.py <input_pdf> <output_pdf> <json_file1> <json_file2> ... <json_fileN>"
        )
        sys.exit(1)

    input_pdf_path = sys.argv[1]
    output_pdf_path = sys.argv[2]
    json_file_paths = sys.argv[3:]

    attach_files_to_pdf(input_pdf_path, json_file_paths, output_pdf_path)
