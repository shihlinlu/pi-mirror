'''

This is a pasted boiler plate for reference. It is best to use an IDE like PyCharm or VSCode to edit these documents.
I added them to our project as boiler plates so that I would have offline access to study them.

# Module that contains the functions necessary for the operation
# of the Sensly HAT

# Import common modules needed for script
import time
from math import log10

# Import installed modules need for script
import smbus as I2C

# Define the i2c address for the Sensly HAT
I2C_Addr = 0x05

# LED Constants
# Array containing RGB values for LED [RED Brightness, Green Brightness, Blue Brightness]
Green = [0x00,0x00,0xFF] 
Orange = [0xFF,0x09,0x00]
Off = [0x00,0x00,0x00]

# i2c cmd to set LED value
LEDcmd = 0x07 

# MQ Constants for interpreting raw sensor data
MaxADC = 4095
RLOAD = 10000

# PM Constants for interpreting raw PM data
NODUSTVOLTAGE = 500
COVRATIO = 0.2


class Sensor:

    def __init__(self, name, R0, RSAIR):
        self.name = name
        i2c = I2C.SMBus(1)  
        self._device = i2c
        self.R0 = R0
        self.RLOAD = RLOAD
        self.RSAIR = RSAIR
        self.MaxADC = MaxADC
        
    # Function to get raw data for the sensors from the Sensly HAT via the i2c peripheral
    def Get_rawdata(self,cmd):
        data = []
        self._device.write_byte(I2C_Addr,cmd)
        time.sleep(0.01)
        data.append(self._device.read_byte(I2C_Addr))
        time.sleep(0.01)
        data.append(self._device.read_byte(I2C_Addr))

        self.Raw = data[0] 
        self.Raw = (self.Raw<<8) | data[1]
        return self.Raw
    
    # Function to convert the raw data to a resistance value 
    def Get_RS(self,cmd):
        self.RS = ((float(self.MaxADC)/float(self.Get_rawdata(cmd))-1)*self.RLOAD)
        return self.RS
    
    # Function to calculate the RS(Sensor Resistance)/R0(Base Resistance) ratio    
    def Get_RSR0Ratio(self,cmd):
        self.rsro = float(self.Get_RS(cmd)/self.R0)
        return self.rsro
    
    # Experimental function to calibrate the MQ Sensors
    def Calibrate(self, cmd, Cal_Sample_Time):
        AvRs = 0
        for x in range(Cal_Sample_Time):
            AvRs = AvRs + self.Get_RS(cmd)
            time.sleep(1)
        AvRs = AvRs/Cal_Sample_Time
        self.RZERO = AvRs/RSAIR
        return self.RZERO
    
    # Function to calculate the voltage from raw PM data
    def Get_PMVolt(self, cmd):
        self.PMVolt = ((3300.00/self.MaxADC)*float(self.Get_rawdata(cmd))*11.00)
        return self.PMVolt
    
    # Function to calculate the densisty of the particulate matter detected 
    def Get_PMDensity(self, cmd):
        self.Get_PMVolt(cmd)
        if (self.PMVolt >= NODUSTVOLTAGE):
            self.PMVolt -= NODUSTVOLTAGE
            self.PMDensity = self.PMVolt * COVRATIO

        else:
            self.PMDensity = 0            
        return self.PMDensity
    
    # Function to correct the RS/R0 ratio based on temperature and relative humidity
    def Corrected_RS_RO(self, cmd, temperature, humidity, Const_33 = [], Const_85 = []):
        rsro_ambtemp_33RH = (Const_33[0]*pow(temperature,3)) + (Const_33[1]*pow(temperature,2)) + (Const_33[2]*temperature) + Const_33[3]
        rsro_ambtemp_85RH = (Const_85[0]*pow(temperature,3)) + (Const_85[1]*pow(temperature,2)) + (Const_85[2]*temperature) + Const_85[3]
        rsro_ambtemp_65RH = ((65.0-33.0)/(85.0-65.0)*(rsro_ambtemp_85RH-rsro_ambtemp_33RH)+rsro_ambtemp_33RH)*1.102
        if humidity < 65:
            rsro_ambtemp_ambRH = (humidity-33)/(65-33)*(rsro_ambtemp_65RH-rsro_ambtemp_33RH)+rsro_ambtemp_33RH
        else:
            rsro_ambtemp_ambRH = (humidity-65)/(85-65)*(rsro_ambtemp_85RH-rsro_ambtemp_65RH)+rsro_ambtemp_65RH
        #calculate correction factor
        refrsro_at_20C65RH = 1.00
        rsroCorrPct = 1 + (refrsro_at_20C65RH - rsro_ambtemp_ambRH)/ refrsro_at_20C65RH
        correctedrsro = rsroCorrPct * (self.Get_RSR0Ratio(cmd))
        return correctedrsro
    
    # Function to correct the RS/R0 ratio based on temperature and relative humidity for the MQ2
    def Corrected_RS_RO_MQ2(self, cmd, temperature, humidity, Const_30 = [], Const_60 = [], Const_85 = []):
        rsro_ambtemp_30RH = (Const_30[0]*pow(temperature,3)) + (Const_30[1]*pow(temperature,2)) + (Const_30[2]*temperature) + Const_30[3]
        rsro_ambtemp_60RH = (Const_60[0]*pow(temperature,3)) + (Const_60[1]*pow(temperature,2)) + (Const_60[2]*temperature) + Const_60[3]
        rsro_ambtemp_85RH = (Const_85[0]*pow(temperature,3)) + (Const_85[1]*pow(temperature,2)) + (Const_85[2]*temperature) + Const_85[3]
        
        if humidity < 60:
            rsro_ambtemp_ambRH = (humidity-30)/(60-30)*(rsro_ambtemp_60RH-rsro_ambtemp_30RH)+rsro_ambtemp_30RH
        else:
            rsro_ambtemp_ambRH = (humidity-60)/(85-60)*(rsro_ambtemp_85RH-rsro_ambtemp_60RH)+rsro_ambtemp_60RH
        # Calculate correction factor
        refrsro_at_20C60RH = 1.00
        rsroCorrPct = 1 + (refrsro_at_20C60RH - rsro_ambtemp_ambRH)/ refrsro_at_20C60RH
        correctedrsro = rsroCorrPct * (self.Get_RSR0Ratio(cmd))
        return correctedrsro
    

class Gas:
    
    def __init__(self,name,rsromax,rsromin,gradient,intercept, threshold, LED = []):
        self.name = name
        i2c = I2C.SMBus(1)  
        self._device = i2c
        self.min = rsromin
        self.max = rsromax
        self.gradient = gradient
        self.intercept = intercept
        self.threshold = threshold
        self.LED = LED
        LEDcmd = 0x07
    # Function to calculate the PPM of the specific gas
    def Get_PPM(self, rs_ro):
        self.PPM = pow(10,((self.gradient*(log10(rs_ro)))+self.intercept))
        return self.PPM
    
    # Function to set the LED Color, used for setting alarms points
    def Set_LED(self, LEDColour):  # LEDColour = Red , Green, Blue Brightness values from 0 - 255 in an array   
        self._device.write_byte(I2C_Addr,LEDcmd)
        for x in range(3):
            self._device.write_byte(I2C_Addr,self.LEDColour[x])
            
    # Function to check the PPM value against the predefined threshold         
    def Chk_threshold(self):
        if self.PPM < self.threshold:
            self.Set_LED(Green)
        elif self.PPM == self.threshold:
            self.Set_LED(Orange)
        elif self.PPM > self.threshold:
            self.Set_LED(self.LED)
