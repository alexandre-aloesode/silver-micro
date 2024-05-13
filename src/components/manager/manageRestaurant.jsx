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
import { useEffect, useState } from "react";
import { dbGet, dbPut } from "../../api/database";

export default function ManageRestaurant(params) {
  const [restaurantData, setRestaurantData] = useState();
  const [name, setName] = useState("");
  const [address, setAddress] = useState("");
  const [city, setCity] = useState("");
  const [zipCode, setZipCode] = useState("");
  const [phone, setPhone] = useState("");
  const [email, setEmail] = useState("");
  const [description, setDescription] = useState("");
  const [selectedType, setSelectedType] = useState([]);
  const [allTypes, setAllTypes] = useState([]);
  const [totalCapacity, setTotalCapacity] = useState("");
  const [averagePrice, setAveragePrice] = useState("");

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

  function loadRestaurant() {
    dbGet({
      route: "restaurant",
      params: {
        restaurant_id: params.restaurant_id,
        restaurant_name: "",
        restaurant_address: "",
        restaurant_zip_code: "",
        restaurant_city: "",
        restaurant_phone: "",
        restaurant_email: "",
        total_capacity: "",
        average_price: "",
        restaurant_type_name: "",
        restaurant_description: "",
      },
    }).then((data) => {
      setRestaurantData(data[0]);
    });
  }

  async function handleClick() {
    const restaurantData = new FormData();
    restaurantData.append("restaurant_id", params.restaurant_id);
    restaurantData.append("restaurant_name", name);
    restaurantData.append("restaurant_address", address);
    restaurantData.append("restaurant_zip_code", zipCode);
    restaurantData.append("restaurant_city", city);
    restaurantData.append("restaurant_phone", phone);
    restaurantData.append("restaurant_email", email);
    restaurantData.append("restaurant_description", description);
    restaurantData.append("total_capacity", totalCapacity);
    restaurantData.append("average_price", averagePrice);
    restaurantData.append("restaurant_type", selectedType);
    const request = await dbPut("restaurant", restaurantData);
    if (request) {
      loadRestaurant();
    }
  }

  useEffect(() => {
    if (params.restaurant_id !== "") loadRestaurant();
  }, [params.restaurant_id]);

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

  useEffect(() => {
    setName(restaurantData?.restaurant_name);
    setAddress(restaurantData?.restaurant_address);
    setZipCode(restaurantData?.restaurant_zip_code);
    setCity(restaurantData?.restaurant_city);
    setPhone(restaurantData?.restaurant_phone);
    setEmail(restaurantData?.restaurant_email);
    setDescription(restaurantData?.restaurant_description);
    setTotalCapacity(restaurantData?.total_capacity);
    setAveragePrice(restaurantData?.average_price);
    setSelectedType(restaurantData?.restaurant_type_name);
  }, [restaurantData]);

  return (
    <div>
      <TextField id="outlined-basic" label="Nom du restaurant" variant="outlined" value={name} onChange={(e) => setName(e.target.value)} />
      <TextField id="outlined-basic" label="Adresse" variant="outlined" value={address} onChange={(e) => setAddress(e.target.value)} />
      <TextField id="outlined-basic" label="Ville" variant="outlined" value={city} onChange={(e) => setCity(e.target.value)} />
      <TextField id="outlined-basic" label="Code postal" variant="outlined" value={zipCode} onChange={(e) => setZipCode(e.target.value)} />
      <TextField id="outlined-basic" label="Téléphone" variant="outlined" value={phone} onChange={(e) => setPhone(e.target.value)} />
      <TextField id="outlined-basic" label="Email" variant="outlined" value={email} onChange={(e) => setEmail(e.target.value)} />
      {/* {selectedType > 0 && ( */}
      <FormControl>
        <InputLabel id="inputCat">Type de cuisine</InputLabel>
        <Select
          // multiple
          labelId="inputCat"
          id="inputCat"
          value={selectedType?.length > 0 ? selectedType : []}
          label="Type de cuisine"
          onChange={(e) => {
            // setSelectedType([...selectedType, e.target.value]);
            if(selectedType.indexOf(e.target.value) > -1) {
              setSelectedType(selectedType.filter((type) => type !== e.target.value))
            } else {
              setSelectedType([...selectedType, e.target.value]);
            }
          }}
          input={<OutlinedInput label="Tag" />}
          renderValue={(selected) => selected.join(", ")}
          MenuProps={MenuProps}
          required
        >
          {allTypes.map((type) => (
            <MenuItem key={type.type_name} value={type.type_name}>
              <Checkbox checked={selectedType?.indexOf(type.type_name) > -1} />
              <ListItemText primary={type.type_name} />
            </MenuItem>
          ))}
        </Select>
      </FormControl>
      <TextField id="outlined-basic" label="Description" variant="outlined" value={description} onChange={(e) => setDescription(e.target.value)} />
      <TextField id="outlined-basic" label="Capacité totale" variant="outlined" value={totalCapacity} onChange={(e) => setTotalCapacity(e.target.value)} />
      <TextField id="outlined-basic" label="Prix moyen" variant="outlined" value={averagePrice} onChange={(e) => setAveragePrice(e.target.value)} />
      <Button
        variant="contained"
        color="primary"
        onClick={() => {
          handleClick();
        }}
      >
        Modifier
      </Button>
    </div>
  );
}
