export const requiredValidation = ({ value, label }) => {
  let error = null;

  if (!value) {
    error = `${label} is required`;
  }
  return error;
};
