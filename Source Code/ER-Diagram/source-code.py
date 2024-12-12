import random
from datetime import datetime
import networkx as nx
import matplotlib.pyplot as plt
from graphviz import Digraph
import graphviz


dot = Digraph(comment='Parcel Delivery ER Diagram', format='png')

# Entities (Tables)
dot.node('Customer', 'Customer\nCustomerID (PK)\nFirstName\nLastName\nContactNumber\nEmail\nAddressLine1\nAddressLine2\nAddressCode\nJoinDateTime\nPassword\nPreferredContactMethod')
dot.node('Employee', 'Employee\nEmployeeID (PK)\nFirstName\nLastName\nRole\nDepartment\nContactNumber\nEmail\nWarehouseID (FK)\nStoreID (FK)\nPassword\nHireDate')
dot.node('Warehouse', 'Warehouse\nWarehouseID (PK)\nPostcode (FK)\nCapacity\nLocation\nOperationalStatus')
dot.node('Parcel', 'Parcel\nParcelID (PK)\nWeight\nBoxTypeID (FK)\nWarehouseID (FK)\nReceiverFirstName\nReceiverLastName\nProvince\nPostcode\nAddress\nEmployeeID (FK)\nDeliveryDate\nFleetID (FK)')
dot.node('ParcelStatusHistory', 'ParcelStatusHistory\nParcelStatusID (PK)\nParcelID (FK)\nStatus\nTimestamp\nLocationDetailed\nEmployeeID (FK)')
dot.node('Order', 'Order\nOrderID (PK)\nCustomerID (FK)\nOrderDate\nDeliveryType\nTotalPrice\nPaymentStatus\nOverallStatus')
dot.node('Fleet', 'Fleet\nFleetID (PK)\nVehicleType\nFuelConsumption\nAvailabilityStatus\nMaintenanceStatus')
dot.node('FleetMaintenance', 'FleetMaintenance\nMaintenanceID (PK)\nFleetID (FK)\nMaintenanceDate\nDetails')
dot.node('EmployeePerformance', 'EmployeePerformance\nPerformanceID (PK)\nEmployeeID (FK)\nDeliverySpeed\nDrivingHabits\nIdleTime\nFeedbackScore\nEvaluationDate')
dot.node('Store', 'Store\nStoreID (PK)\nStoreLocation')
dot.node('StoreWarehouse', 'StoreWarehouse\nStoreID (FK)\nWarehouseID (FK)')
dot.node('OrderParcel', 'OrderParcel\nTrackingNumber (PK)\nOrderID (FK)\nParcelID (FK)')
dot.node('BoxType', 'BoxType\nTypeID (PK)\nBoxSize\nWidth\nLength\nHeight\nPrice')
dot.node('Destination', 'Destination\nPostcode (PK)\nState\nPlaceName\nRegion')


# Relationships (Edges)
dot.edge('Customer', 'Order', label='Places')
dot.edge('Order', 'OrderParcel', label='Contains')
dot.edge('OrderParcel', 'Parcel', label='Includes')
dot.edge('Parcel', 'Warehouse', label='Stored at')
dot.edge('Employee', 'Parcel', label='Delivers')
dot.edge('Employee', 'ParcelStatusHistory', label='Updates Status')
dot.edge('Parcel', 'ParcelStatusHistory', label='Has Status')
dot.edge('Parcel', 'BoxType', label='Uses')
dot.edge('Employee', 'EmployeePerformance', label='Has Performance')
dot.edge('Employee', 'Store', label='Works at')
dot.edge('Employee', 'Warehouse', label='Assigned to')
dot.edge('Store', 'StoreWarehouse', label='Has')
dot.edge('Warehouse', 'StoreWarehouse', label='Is linked with')
dot.edge('Fleet', 'Parcel', label='Used for Delivery')
dot.edge('Fleet', 'FleetMaintenance', label='Has Maintenance')
dot.edge('Parcel', 'Destination', label='Delivered to')


dot.render('parcel_delivery_er_diagram', view=True)
