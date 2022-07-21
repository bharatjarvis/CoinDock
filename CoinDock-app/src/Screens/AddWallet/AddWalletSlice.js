import { createSlice } from "@reduxjs/toolkit";
const initialState = {
  open: false,
};

const popupSlice = createSlice({
  name: "popup",
  initialState,

  reducers: {
    openPopup: (state) => {
      state.open = true;
    },
    closePopup: (state) => {
      state.open = false;
    },
  },
});
export const { openPopup, closePopup } = popupSlice.actions;

export default popupSlice.reducer;

export const { reducer: popupReducer } = popupSlice;
