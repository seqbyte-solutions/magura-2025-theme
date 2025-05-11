import { useState } from "preact/hooks";
import { Input } from "./components/ui/input";
import { Label } from "./components/ui/label";
import { Button } from "./components/ui/button";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "./components/ui/popover";
import { cn } from "./lib/utils";
import { Check, ChevronDown, ChevronsUpDown } from "lucide-react";
import {
  Command,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
} from "./components/ui/command";
import { CommandEmpty } from "cmdk";

type Props = {};

function Form({}: Props) {
  const [formData, setFormData] = useState({
    last_name: "",
    first_name: "",
    email: "",
    phone: "",
    county: "",
    locality: "",
    reciep_image: null,
  });

  const [countyPopoverOpen, setCountyPopoverOpen] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevState) => ({
      ...prevState,
      [name]: value,
    }));
  };
  const [open, setOpen] = useState(false);
  const [value, setValue] = useState("");
  return (
    <div>
      <form className="flex flex-col justify-center items-center w-full mx-auto relative">
        <div className="flex flex-col justify-center items-center gap-4 max-w-[400px] w-full mx-auto relative">
          <div className="grid w-full items-center gap-1">
            <Label htmlFor="form_field_last_name">Nume</Label>
            <Input
              type="text"
              id="form_field_last_name"
              name="last_name"
              value={formData.last_name}
              onChange={handleChange}
              required
            />
          </div>
          <div className="grid w-full items-center gap-1">
            <Label htmlFor="form_field_first_name">Prenume</Label>
            <Input
              type="text"
              id="form_field_first_name"
              name="first_name"
              value={formData.first_name}
              onChange={handleChange}
              required
            />
          </div>
          <div className="grid w-full items-center gap-1">
            <Label htmlFor="form_field_email">Adresa de email</Label>
            <Input
              type="email"
              id="form_field_email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </div>
          <div className="grid w-full items-center gap-1">
            <Label htmlFor="form_field_phone">Număr de telefon</Label>
            <Input
              type="tel"
              id="form_field_phone"
              name="phone"
              value={formData.phone}
              onChange={handleChange}
              required
            />
          </div>

          <div className="grid w-full items-center gap-1">
            <Label htmlFor="form_field_county">Județ</Label>
            <Popover
              open={countyPopoverOpen}
              onOpenChange={setCountyPopoverOpen}
            >
              <PopoverTrigger asChild>
                <Button
                  variant="outline"
                  role="combobox"
                  aria-expanded={countyPopoverOpen}
                  className={cn(
                    "w-full justify-between",
                    !formData.county && ""
                  )}
                >
                  {formData.county ? formData.county : "Alege județul..."}{" "}
                  <ChevronDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                </Button>
              </PopoverTrigger>
              <PopoverContent className={"w-full p-0"}>
                <Command>
                  <CommandInput />
                  <CommandList>
                    <CommandEmpty>No results found.</CommandEmpty>
                    <CommandGroup>
                      <CommandItem
                        value="Alba"
                        onSelect={(currentValue) => {
                          setFormData((prevData) => ({
                            ...prevData,
                            county: currentValue,
                          }));
                          setCountyPopoverOpen(false);
                        }}
                      >
                        Value{" "}
                        <Check
                          className={cn(
                            "ml-auto",
                            "Alba" === formData.county
                              ? "opacity-100"
                              : "opacity-0"
                          )}
                        />
                      </CommandItem>
                      <CommandItem
                        value="Constanta"
                        onSelect={(currentValue) => {
                          setFormData((prevData) => ({
                            ...prevData,
                            county: currentValue,
                          }));
                          setCountyPopoverOpen(false);
                        }}
                      >
                        Value{" "}
                        <Check
                          className={cn(
                            "ml-auto",
                            "Constanta" === formData.county
                              ? "opacity-100"
                              : "opacity-0"
                          )}
                        />
                      </CommandItem>
                    </CommandGroup>
                  </CommandList>
                </Command>
              </PopoverContent>
            </Popover>
          </div>
          {/* 
          <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
              <Button
                variant="outline"
                role="combobox"
                aria-expanded={open}
                className="w-[200px] justify-between"
              >
                {value
                  ? frameworks.find((framework) => framework.value === value)
                      ?.label
                  : "Select framework..."}
                <ChevronsUpDown className="opacity-50" />
              </Button>
            </PopoverTrigger>
            <PopoverContent className="w-[200px] p-0">
              <Command>
                <CommandInput placeholder="Search framework..." />
                <CommandList>
                  <CommandEmpty>No framework found.</CommandEmpty>
                  <CommandGroup>
                    {frameworks.map((framework) => (
                      <CommandItem
                        key={framework.value}
                        value={framework.value}
                        onSelect={(currentValue) => {
                          setValue(currentValue === value ? "" : currentValue);
                          setOpen(false);
                        }}
                      >
                        {framework.label}
                        <Check
                          className={cn(
                            "ml-auto",
                            value === framework.value
                              ? "opacity-100"
                              : "opacity-0"
                          )}
                        />
                      </CommandItem>
                    ))}
                  </CommandGroup>
                </CommandList>
              </Command>
            </PopoverContent>
          </Popover> */}
          <div className="w-full">
            <Button
              className={
                "w-full bg-[var(--red)] text-[var(--white)] font-['Baloo2'] text-[1rem] font-medium hover:bg-[var(--light-red)] hover:text-[var(--red)]"
              }
              size="lg"
              variant="default"
            >
              Trimite
            </Button>
          </div>
        </div>
      </form>
    </div>
  );
}

export default Form;
