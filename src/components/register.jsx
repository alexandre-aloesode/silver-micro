import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { dbPost } from "../api/database.jsx";
import NavBar from "./navBar.jsx";
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import InputLabel from '@mui/material/InputLabel';

function UserRegister() {

  const [email, setEmail] = React.useState("");
  const [password, setPassword] = React.useState("");
  const [message, setMessage] = React.useState("");
  const [role, setRole] = React.useState("1");
  const [phone, setPhone] = React.useState("");

  async function handleRegister() {
    const userData = new FormData();
    userData.append("email", email);
    userData.append("password", password)
    userData.append("role", role);
    userData.append("phone", phone);
    
    const request = await dbPost("register", userData);
    setMessage(request.message);
  }

  return (
    <Box
      component="form"
      sx={{
        "& .MuiTextField-root": { m: 1, width: "25ch" },
      }}
      noValidate
      autoComplete="off"
    >
      <FormControl fullWidth>
        <InputLabel id="demo-simple-select-label">Je suis un :</InputLabel>
        <Select
          labelId="demo-simple-select-label"
          id="demo-simple-select"
          value={role}
          label="Age"
          onChange={(e)=>setRole(e.target.value)}
        >
          <MenuItem value={1}>Client</MenuItem>
          <MenuItem value={2}>Restaurateur</MenuItem>
        </Select>
      </FormControl>
      <TextField
        required
        id="outlined-required"
        label="Email"
        value={email}
        onChange={(e) => {
          setEmail(e.target.value);
        }}
      />
      {role=="2" && 
      <TextField
      required
      id="outlined-required"
      label="N° Téléphone"
      value={phone}
      onChange={(e) => {
        setPhone(e.target.value);
      }}
    />
      }
      <TextField
        required
        id="outlined-password-input"
        label="Password"
        type="password"
        value={password}
        onChange={(e) => {
          setPassword(e.target.value);
        }}
        autoComplete="current-password"
      />
      <Button variant="contained" onClick={handleRegister}>
        Register
      </Button>
      <div>
        <p>{message}</p></div>
    </Box>
  );
}

export default UserRegister;
