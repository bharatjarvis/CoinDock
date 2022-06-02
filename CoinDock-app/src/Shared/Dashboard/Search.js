import React from "react";
import { Form, FormControl, Button } from "react-bootstrap";

const Search = () => {
  return (
    <Form className="d-flex">
      <FormControl
        type="search"
        placeholder="Search"
        className="me-2"
        aria-label="Search"
      />

      <Button variant="outline-primary">Search</Button>
    </Form>
  );
};

export default Search;
