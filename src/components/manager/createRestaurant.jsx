import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import InputLabel from '@mui/material/InputLabel';
import CancelIcon from '@mui/icons-material/Cancel';
import { useContext, useEffect, useState } from "react";
import { dbPost } from "../../api/database";

export default function CreateRestaurant(params) {
    const [name, setName] = React.useState("");
    const [address, setAddress] = React.useState("");
    const [city, setCity] = React.useState("");
    const [zipCode, setZipCode] = React.useState("");
    const [phone, setPhone] = React.useState("");
    const [email, setEmail] = React.useState("");
    const [description, setDescription] = React.useState("");

  async function handleClick() {
        const restaurantData = new FormData();
        restaurantData.append("name", name);
        restaurantData.append("address", address);
        restaurantData.append("city", city);
        restaurantData.append("zipCode", zipCode);
        restaurantData.append("phone", phone);
        restaurantData.append("email", email);
        restaurantData.append("description", description);
        const request = await dbPost("restaurant", restaurantData);
        console.log(request);
        // params.openModal(false);
    }

  return (
    <div>
        <CancelIcon onClick={() => {params.openModal(false)}} />
      <h1>Ajouter un restaurant</h1>
      <TextField id="outlined-basic" label="Nom du restaurant" variant="outlined" value={name}
          onChange={(e)=>setName(e.target.value)} />
      <TextField id="outlined-basic" label="Adresse" variant="outlined" value={address}
          onChange={(e)=>setAddress(e.target.value)} />
      <TextField id="outlined-basic" label="Ville" variant="outlined" value={city}
          onChange={(e)=>setCity(e.target.value)}/>
      <TextField id="outlined-basic" label="Code postal" variant="outlined" value={zipCode}
          onChange={(e)=>setZipCode(e.target.value)}/>
      <TextField id="outlined-basic" label="Téléphone" variant="outlined" value={phone}
          onChange={(e)=>setPhone(e.target.value)}/>
      <TextField id="outlined-basic" label="Email" variant="outlined" value={email}
          onChange={(e)=>setEmail(e.target.value)} />
      <TextField id="outlined-basic" label="Description" variant="outlined" value={description}
          onChange={(e)=>setDescription(e.target.value)} />
      <Button
        variant="contained"
        onClick={handleClick}
      >
        Ajouter
      </Button>
    </div>
  );
}
