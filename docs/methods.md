# Methods

The Form object has the following methods:

- **fill**: Fill the form with an array of data (e.g. $_POST)
- **extract**: Extract the filled in form values
- **validate**: Validate the form and add errors where needed
- **addErrors**: Add custom errors (after validation)
- **render**: Output the form with or without root element

## Tree

- Form
  - Fieldset
    - Field
      - Control (Input / Select / Checkbox)
      - Label
      - Error
      - Validators
