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
    //How can i console.log the params sent from the axios.post
    console.log("pppppp", req.headers.newfilename);
    // // console.log("ffffffff", req);
    // console.log("yyyyyy", req.body);
    // console.log("ggggggg", cb);
    // console.log("tttttttt", file);
    cb(null, req.headers.newfilename);
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
  // console.log("rrrrrrr", req.file);
  console.log(req.headers.newfilename + " file successfully uploaded !!");
  res.sendStatus(200);
  //I need to send the name of the file as a response
  // res.send(req.file.originalname);
});

app.listen(3000, () => console.log("Listening on port 3000"));
