import React, { useState, useRef } from "react";
import DatePicker from "react-datepicker";
import moment from "moment";
import "react-datepicker/dist/react-datepicker.css";
function DatePick({ name, onChange }) {
  // const inputRef = useRef();
  const [selectedDate, setSelectedDate] = useState("");

  const handleChanges = (value) => {
    // console.log(inputRef);
    // inputRef.current.set(value);
    if (onChange) {
      onChange({
        target: {
          value: moment(value).format("YYYY-MM-DD"),
          name,
        },
      });
    }
    setSelectedDate(value);
  };

  // const handleInputChange = (...e) => {
  //   inputRef.current.onChange.call(null, ...e);
  // };

  return (
    <React.Fragment>
      <DatePicker
        name={name}
        className="form-control mt-1 py-8"
        selected={selectedDate}
        onChange={handleChanges}
        dateFormat="dd/MM/yyyy"
      />
    </React.Fragment>
  );
}
export default DatePick;
