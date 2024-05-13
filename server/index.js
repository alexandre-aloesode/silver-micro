import { createRequire } from "module";
import path from "path";
import { fileURLToPath } from "url";
const require = createRequire(import.meta.url);
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const express = require("express");
const cors = require("cors");
const multer = require("multer");

// setup multer for file upload
var storage = multer.diskStorage({
  destination: "./restaurant_images",
  filename: function (req, file, cb) {
    cb(null, file.originalname);
  },
});

const app = express();
const upload = multer({ storage: storage });

app.use(express.json());
// serving front end build files
app.use(express.static(__dirname + "/../restaurant_images"));

const corsOptions = {
    origin: "http://localhost:5173",
    optionsSuccessStatus: 200,
  };
app.use(cors(corsOptions));


// route for file upload
app.post("/api/uploadfile", upload.single("myFile"), (req, res, next) => {  
  console.log(req.file.originalname + " file successfully uploaded !!");
  res.sendStatus(200);
  //I need to send the name of the file as a response
  res.send(req.file.originalname);
});

app.listen(3000, () => console.log("Listening on port 3000"));
