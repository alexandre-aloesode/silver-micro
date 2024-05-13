import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import InputLabel from "@mui/material/InputLabel";
import ListItemText from "@mui/material/ListItemText";
import Checkbox from "@mui/material/Checkbox";
import OutlinedInput from "@mui/material/OutlinedInput";
import CancelIcon from "@mui/icons-material/Cancel";
import { useContext, useEffect, useState } from "react";
import { dbPost, dbGet } from "../../api/database";
import { Check } from "@mui/icons-material";

export default function CreateRestaurant(params) {
  const [name, setName] = React.useState("");
  const [address, setAddress] = React.useState("");
  const [city, setCity] = React.useState("");
  const [zipCode, setZipCode] = React.useState("");
  const [phone, setPhone] = React.useState("");
  const [email, setEmail] = React.useState("");
  const [description, setDescription] = React.useState("");
  const [selectedType, setSelectedType] = useState([]);
  const [allTypes, setAllTypes] = useState([]); // [type_id, type_name
  const [totalCapacity, setTotalCapacity] = React.useState("");
  const [averagePrice, setAveragePrice] = React.useState("");

  const ITEM_HEIGHT = 48;
  const ITEM_PADDING_TOP = 8;
  const MenuProps = {
    PaperProps: {
      style: {
        maxHeight: ITEM_HEIGHT * 4.5 + ITEM_PADDING_TOP,
        width: 250,
      },
    },
  };

  useEffect(() => {
    dbGet({
      route: "type",
      params: {
        type_id: "",
        type_name: "",
      },
    }).then((data) => {
      setAllTypes(data);
    });
  }, []);

  async function handleClick() {
    const restaurantData = new FormData();
    restaurantData.append("name", name);
    restaurantData.append("address", address);
    restaurantData.append("zip_code", zipCode);
    restaurantData.append("city", city);
    restaurantData.append("phone", phone);
    restaurantData.append("email", email);
    restaurantData.append("description", description);
    restaurantData.append("type", selectedType);
    restaurantData.append("total_capacity", totalCapacity);
    restaurantData.append("average_price", averagePrice);
    const request = await dbPost("restaurant", restaurantData);
    // params.openModal(false);
  }

  return (
    <div>
      <CancelIcon
        onClick={() => {
          params.openModal(false);
        }}
      />
      <h1>Ajouter un restaurant</h1>
      <TextField id="outlined-basic" label="Nom du restaurant" variant="outlined" value={name} onChange={(e) => setName(e.target.value)} />
      <TextField id="outlined-basic" label="Adresse" variant="outlined" value={address} onChange={(e) => setAddress(e.target.value)} />
      <TextField id="outlined-basic" label="Ville" variant="outlined" value={city} onChange={(e) => setCity(e.target.value)} />
      <TextField id="outlined-basic" label="Code postal" variant="outlined" value={zipCode} onChange={(e) => setZipCode(e.target.value)} />
      <TextField id="outlined-basic" label="Téléphone" variant="outlined" value={phone} onChange={(e) => setPhone(e.target.value)} />
      <TextField id="outlined-basic" label="Email" variant="outlined" value={email} onChange={(e) => setEmail(e.target.value)} />
      <TextField id="outlined-basic" label="Description" variant="outlined" value={description} onChange={(e) => setDescription(e.target.value)} />
      <FormControl>
        <InputLabel id="inputCat">Type de cuisine</InputLabel>
        <Select
          labelId="inputCat"
          id="inputCat"
          value={selectedType}
          label="Type de cuisine"
          onChange={(e) => {
            setSelectedType([...selectedType, e.target.value]);
          }}
          input={<OutlinedInput label="Tag" />}
          renderValue={(selected) => selected.join(", ")}
          MenuProps={MenuProps}
          // color={errors.type === true ? "warning" : "success"}
          required
        >
          {allTypes.map((type) => (
            <MenuItem key={type.type_id} value={type.type_name}>
              <Checkbox checked={selectedType.indexOf(type.type_id) > -1} />
              <ListItemText primary={type.type_name} />
            </MenuItem>
          ))}
          {/* <MenuItem>Catégories</MenuItem>
          <MenuItem value={1}>Débit</MenuItem>
          <MenuItem value={2}>Crédit</MenuItem> */}
        </Select>
      </FormControl>
      <TextField id="outlined-basic" label="Capacité totale" variant="outlined" value={totalCapacity} onChange={(e) => setTotalCapacity(e.target.value)} />
      <TextField id="outlined-basic" label="Prix moyen" variant="outlined" value={averagePrice} onChange={(e) => setAveragePrice(e.target.value)} />
      <Button
        variant="contained"
        onClick={() => {
          handleClick();
        }}
      >
        Ajouter
      </Button>
    </div>
  );
}
