            function convertInvFromValue(val) {
                let result = "";
                switch (val) {
                    case "0":
                        result = "Q";
                        break;
                    case "1":
                        result = "A";
                        break;
                    case "2":
                        result = "B";
                        break;
                    case "3":
                        result = "Y";
                        break;
                    case "4":
                        result = "Z";
                        break;
                    case "5":
                        result = "C";
                        break;
                    case "6":
                        result = "F";
                        break;
                    case "7":
                        result = "D";
                        break;
                    case "8":
                        result = "E";
                        break;
                    case "9":
                        result = "P";
                        break;
                }
                return result;
            }

            function convertInvFromString(val) {
                let result = "";
                switch (val) {
                    case "Q":
                        result = "0";
                        break;
                    case "A":
                        result = "1";
                        break;
                    case "B":
                        result = "2";
                        break;
                    case "Y":
                        result = "3";
                        break;
                    case "Z":
                        result = "4";
                        break;
                    case "C":
                        result = "5";
                        break;
                    case "F":
                        result = "6";
                        break;
                    case "D":
                        result = "7";
                        break;
                    case "EH":
                        result = "8";
                        break;
                    case "P":
                        result = "9";
                        break;
                }
                return result;
            }