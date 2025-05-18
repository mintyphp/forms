# Classes

## Elements

In alphabetical order: 

- **Checkboxes**: Array of checkboxes, for multi-selection
- **Checkbox**: Single checkbox that can be checked or not
- **Error**: Representation of an error message
- **Field**: Wrapper for a label + control + error
- **Fieldset**: Set of fields to be grouped in a fieldset
- **Form**: Root element representing the entire form
- **Header**: A header that can be used to partition a form
- **Input**: Any input (type: text, password, email or other)
- **Label**: A label that describes the input
- **Legend**: A legend for a fieldset
- **Select**: A select or drop-down input
- **TextArea**: A text area for larger text input

## Validators

In alphabetical order: 

- **EmailValidator**: Validate email addresses
- **ExpressionValidator**: Numeric expressions (>, >=, <, <=)
- **IntValidator**: Validate whole numbers
- **MaxLengthValidator**: Set a maximum input length
- **MinLengthValidator**: Set a minimum input length
- **RegexValidator**: Validate against a regular expression
- **RequiredValidator**: Field cannot be empty
- **UrlValidator**: Validate a URL (http only)

## Tree

A Form element has the following internal tree structure:

- Form
  - Fieldset
    - Legend
    - Header
    - Field[]
      - Label
      - Control (Input/Select/Checkbox/TextArea)
      - Error
      - Validator[]