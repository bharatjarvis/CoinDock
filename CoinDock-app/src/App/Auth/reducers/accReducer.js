import { createSlice } from "@reduxjs/toolkit";
export const accReducer = createSlice ({
    name:'account',
    initialState :{
        open: false,
        type: null
    },
    reducers:{
        openDialogue:(state,action) =>{
            state.type = action.payload.type
            state.open = true
        },
        closeDialogue:(state)=>{
            state.open = false
            state.type = null
        }
    }
})
export const {openDialogue,closeDialogue} = accReducer.actions;
export default accReducer.reducer;